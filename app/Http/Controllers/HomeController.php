<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $posts = Post::public()->latest()->paginate(24);
        return view('home', [
            'posts' => $posts
        ]);
    }
}
