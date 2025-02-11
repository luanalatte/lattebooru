<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\SearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request, SearchService $searchService)
    {
        $search = $request->query('q');

        $tags = $searchService->parseSearchString($search);

        $query = Post::with(['thumbnail', 'tags']);
        foreach ($tags['tags'] as $tag) {
            $query->whereRelation('tags', 'name', $tag);
        }

        $query->whereDoesntHave('tags', function($query) use ($tags) {
            $query->whereIn('name', $tags['exclude']);
        });

        $posts = $query->paginate(24)->appends(['q' => $search]);

        return view('search', [
            'posts' => $posts
        ]);
    }
}
