<?php

namespace App\Http\Controllers;

use App\Mail\NewUserAdmin;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (! Auth::attempt($data, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Incorrect email or password.',
            ]);
        }

        $request->session()->regenerate();

        if (Auth::user()->isAdmin()) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('account'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:120',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string|max:30',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // role mass-assign edilemez; DB varsayılanı 'customer' otomatik uygulanır.
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'phone'    => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
        ]);

        event(new Registered($user));   // dogrulama maili gonderir

        // Yöneticiye yeni üye bildirimi — mail patlarsa kayıt akışı bozulmasın.
        try {
            if ($adminMail = setting('eposta')) {
                Mail::to($adminMail)->send(new NewUserAdmin($user));
            }
        } catch (\Throwable $e) {
            Log::error('New user email could not be sent', ['err' => $e->getMessage()]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('account')->with('success', 'Your account has been created. Welcome!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
