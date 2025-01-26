<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function index()
    {
        Gate::authorize('create', User::class);

        return view('auth.register');
    }

    public function register(Request $request)
    {
        Gate::authorize('create', User::class);

        $validated = $request->validate([
            'username' => 'required|min:3|max:20|alpha_dash:ascii|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['bail', 'required', 'string', Password::default(), 'confirmed'],
        ]);

        $user = User::create($validated);
        $user->assignRole('user');

        event(new Registered($user));

        Auth::login($user);

        return redirect('/');
    }
}
