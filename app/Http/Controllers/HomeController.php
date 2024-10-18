<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $posts = Post::public()->take(10)->get();
        return view('home', [
            'posts' => $posts
        ]);
    }
}
