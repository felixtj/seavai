<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginLog;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'email'            => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'         => ['required', 'confirmed', Password::defaults()],
            'marketing_opt_in' => ['nullable', 'boolean'],
        ]);

        $user = User::create([
            'name'             => $validated['name'],
            'email'            => $validated['email'],
            'password'         => $validated['password'],
            'marketing_opt_in' => $request->boolean('marketing_opt_in'),
        ]);

        event(new Registered($user));

        Auth::login($user);
        LoginLog::record('login_success', $user);

        return redirect()->route('onboarding');
    }
}
