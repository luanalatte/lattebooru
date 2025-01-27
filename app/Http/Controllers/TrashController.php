<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrashController extends Controller
{
    public function index(Request $request)
    {
        $posts = $request->user()->posts()->with('tags')->onlyTrashed()->paginate(24);

        return view('trash', [
            'posts' => $posts
        ]);
    }
}
