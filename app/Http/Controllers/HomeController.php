<?php

namespace App\Http\Controllers;

use App\Http\Resources\TagResource;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $posts = Post::with('tags')->public()->latest()->paginate(24);
        $popularTags = Tag::popular()->withBasicInfo()->take(12)->get();

        return view('home', [
            'posts' => $posts,
            'popularTags' => TagResource::collection($popularTags)
        ]);
    }
}
