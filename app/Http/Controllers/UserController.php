<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index', [
            'users' => User::withCount('posts')->get()
        ]);
    }

    public function show(User $user)
    {
        return view('user.show', [
            'user' => $user
        ]);
    }
}
