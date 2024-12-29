<?php

namespace App\Http\Controllers;

use App\Enums\PostVisibility;
use App\Models\Post;
use App\Services\TagService;
use Exception;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
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

    public function updateTags(Request $request, Post $post, TagService $tagService)
    {
        $validated = $request->validate([
            'tags' => 'required|array',
            'tags.*' => 'boolean'
        ]);

        $removeTags = $tagService->findTags(array_keys(array_filter($validated['tags'], fn ($v) => !boolval($v), ARRAY_FILTER_USE_BOTH)));

        DB::beginTransaction();
        try {
            if (Gate::allows('tag_create')) {
                $addTags = $tagService->findOrCreateTags(array_keys(array_filter($validated['tags'], fn ($v) => boolval($v), ARRAY_FILTER_USE_BOTH)));
            } else {
                $addTags = $tagService->findTags(array_keys(array_filter($validated['tags'], fn ($v) => boolval($v), ARRAY_FILTER_USE_BOTH)));
            }

            $post->tags()->detach($removeTags);
            $post->tags()->syncWithoutDetaching($addTags);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw($e);
        }

        return response()->json([
            'message' => 'Tags updated succesfully.',
            'tags' => $post->tags->fresh()->pluck('name')
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
