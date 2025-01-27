<?php

namespace App\Http\Controllers;

use App\Enums\PostVisibility;
use App\Http\Resources\TagResource;
use App\Models\Post;
use App\Services\PostService;
use App\Services\TagService;
use App\Validation\Rules\UniqueFileHash;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function create()
    {
        Gate::authorize('create', Post::class);

        return view('posts.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Post::class);

        $request->validate([
            'file' => ['bail', 'required', 'image', new UniqueFileHash],
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
            $post = $request->user()->posts()->create([
                'md5' => $hash,
                'ext' => $ext,
                'filename' => e($file->getClientOriginalName()),
                'filesize' => $file->getSize(),
                'width' => $dimensions[0] ?? null,
                'height' => $dimensions[1] ?? null,
            ]);

            $file->storePubliclyAs('images', $hash);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            report($e);

            return back()->withErrors([
                'upload' => trans('upload.error')
            ]);
        }

        $post->regenerateThumbnail();

        return redirect(route('posts.show', [$post]));
    }

    public function show(Post $post)
    {
        Gate::authorize('view', $post);

        $post->load(['tags', 'author', 'comments.author']);

        return view('posts.show', [
            'post' => $post
        ]);
    }

    public function addComment(Post $post, Request $request)
    {
        Gate::authorize('comment', $post);

        $request->validate([
            'comment' => 'required|string'
        ]);

        $comment = $post->comments()->create([
            'user_id' => $request->user()->id,
            'text' => $request->string('comment')
        ]);

        $comment->load('author');

        return response()->json([
            'message' => 'Comment added.',
            'comment' => $comment
        ]);
    }

    public function updateTags(Request $request, Post $post, PostService $postService, TagService $tagService)
    {
        Gate::authorize('editTags', $post);

        $validated = $request->validate([
            'tags' => 'required|array',
            'tags.*' => 'boolean'
        ]);

        $removeTags = $tagService->sanitizeMany(array_keys(array_filter($validated['tags'], fn($v) => !boolval($v), ARRAY_FILTER_USE_BOTH)));
        $addTags = $tagService->sanitizeMany(array_keys(array_filter($validated['tags'], fn($v) => boolval($v), ARRAY_FILTER_USE_BOTH)));

        DB::beginTransaction();
        try {

            $postService->removeTags($post, $removeTags);
            $postService->addTags($post, $addTags);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw ($e);
        }

        $post->load('tags');

        return response()->json([
            'message' => 'Tags updated succesfully.',
            'tags' => TagResource::collection($post->tags)
        ]);
    }

    public function setVisibility(Request $request, Post $post)
    {
        Gate::authorize('update', $post);

        $request->validate([
            'visibility' => ['required', Rule::in(PostVisibility::cases())]
        ]);

        $post->visibility = PostVisibility::from($request->integer('visibility'));
        $post->save();

        return response()->json([
            'message' => 'Visibility changed',
            'visibility' => $post->visibility->toArray()
        ]);
    }

    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        $post->delete();

        return redirect(route('posts.show', [$post]));
    }

    public function restore(Post $post)
    {
        Gate::authorize('restore', $post);

        $post->restore();

        return redirect(route('posts.show', [$post]));
    }

    public function forceDelete(Post $post)
    {
        Gate::authorize('forceDelete', $post);

        $post->forceDelete();

        return redirect('/');
    }

    public function regenerateThumbnail(Post $post)
    {
        Gate::authorize('regenerateThumbnail', $post);

        $post->regenerateThumbnail();

        return response()->json([
            'message' => 'Image scheduled for thumbnail regeneration.'
        ]);
    }
}
