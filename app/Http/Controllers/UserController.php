<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->withCount('posts')->paginate(50);

        return view('users.index', [
            'users' => $users
        ]);
    }

    public function show(User $user)
    {
        $posts = $user->latestPosts()->with('tags')->paginate(12);

        return view('users.show', [
            'user' => $user,
            'posts' => $posts
        ]);
    }
}
