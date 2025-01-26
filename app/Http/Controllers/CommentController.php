<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        Gate::authorize('update', $comment);

        $request->validate([
            'comment' => 'required|string'
        ]);

        $comment->text = $request->string('comment');

        return response()->json([
            'message' => 'Comment edited.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        Gate::authorize('delete', $comment);

        $comment->delete();

        if (!request()->ajax()) {
            return redirect()->back()->with('message', 'Comment deleted.');
        }

        return response()->json([
            'message' => 'Comment deleted.'
        ]);
    }
}
