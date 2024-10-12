<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Exception;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            report ($e);
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
        //
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect('/');
    }
}
