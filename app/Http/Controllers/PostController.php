<?php

namespace App\Http\Controllers;

use App\Enums\PostVisibility;
use App\Models\Post;
use App\Models\Tag;
use Exception;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        return view('post.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image'
        ]);

        $file = $request->file('file');

        try {
            $dimensions = $file->dimensions();
            $hash = md5_file($file->path());
            $ext = $file->extension();
        } catch (Exception) {
            return back()->withErrors([
                'upload' => trans('upload.bad_file')
            ]);
        }

        DB::beginTransaction();

        try {
            /** @var Post $post */
            $post = Post::create([
                'user_id' => $request->user()->id,
                'md5' => $hash,
                'ext' => $ext,
                'filename' => e($file->getClientOriginalName()),
                'filesize' => $file->getSize(),
                'width' => $dimensions[0] ?? null,
                'height' => $dimensions[1] ?? null,
            ]);

            $file->storePubliclyAs('images', $hash);

            DB::commit();
        } catch (UniqueConstraintViolationException) {
            return back()->withErrors([
                'upload' => trans('upload.duplicate')
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            report($e);
            return back()->withErrors([
                'upload' => trans('upload.error')
            ]);
        }

        $post->regenerateThumbnail();

        return redirect(route('post.show', [$post]));
    }

    public function show(Post $post)
    {
        return view('post.show', [
            'post' => $post
        ]);
    }

    public function edit(Post $post)
    {
        //
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'tags' => ['array'],
            'tags.*' => ['boolean']
        ]);

        if (isset($validated['tags'])) {
            $validated['tags'] = array_map(fn ($tag) => strtolower(trim($tag)), $validated['tags']);

            $existingTags = Tag::whereIn('name', array_keys($validated['tags']))->get()->keyBy->name;

            $removeTags = [];
            $addTags = [];

            DB::beginTransaction();
            try {
                foreach ($validated['tags'] as $tag => $v) {
                    if (boolval($v)) {
                        $addTags[] = $existingTags[$tag]?->id ?? Tag::create(['name' => $tag])->id;
                    } elseif (isset($existingTags[$tag])) {
                        $removeTags[] = $existingTags[$tag]->id;
                    }
                }

                $post->tags()->detach($removeTags);
                $post->tags()->syncWithoutDetaching($addTags);

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                throw ($e);
            }
        }

        return view('post.show', [
            'post' => $post
        ]);
    }

    public function setVisibility(Request $request, Post $post)
    {
        $request->validate([
            'visibility' => ['required', Rule::in(PostVisibility::cases())]
        ]);

        $post->visibility = $request->integer('visibility');
        $post->save();

        return back();
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect('/');
    }
}
