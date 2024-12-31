<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->withCount('posts')->paginate(50);

        return view('user.index', [
            'users' => $users
        ]);
    }

    public function show(User $user)
    {
        $posts = $user->latestPosts()->with('tags')->paginate(12);

        return view('user.show', [
            'user' => $user,
            'posts' => $posts
        ]);
    }
}
