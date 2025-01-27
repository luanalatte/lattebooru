<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RegisterController extends Controller
{
    public function index()
    {
        Gate::authorize('create', User::class);

        return view('auth.register');
    }

    public function register(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        $user->assignRole('user');

        event(new Registered($user));

        Auth::login($user);

        return redirect('/');
    }
}
