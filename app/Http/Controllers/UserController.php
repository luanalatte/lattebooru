<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->withCount('posts')->paginate(10);

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

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        $user->assignRole('user');

        event(new Registered($user));

        return back()->with('message', 'User created.');
    }
}
