<?php

namespace App\Http\Controllers;

use App\Enums\Settings;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $posts = Post::with(['tags'])->public()->latest()->paginate(Settings::POSTS_PAGE_SIZE->get());
        $popularTags = Tag::popular()->take(Settings::TAGS_TOP_COUNT->get())->get();

        return view('home', [
            'posts' => $posts,
            'popularTags' => $popularTags
        ]);
    }
}
