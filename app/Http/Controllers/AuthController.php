<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        if (User::exists()) {
            return $this->registroCerrado();
        }

        return view('register');
    }

    public function register(Request $request): RedirectResponse
    {
        if (User::exists()) {
            return $this->registroCerrado();
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = new User($data);
        $user->rol = 'administrador';
        $user->save();

        Auth::login($user);
        $request->session()->regenerate();

        $user->forceFill(['ultimo_acceso' => now()])->save();

        return redirect('/panel');
    }

    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials['estado'] = true;

        if (! Auth::attempt($credentials)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Credenciales incorrectas o cuenta inactiva.']);
        }

        $request->session()->regenerate();

        $request->user()->forceFill(['ultimo_acceso' => now()])->save();

        return redirect('/panel');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    private function registroCerrado(): RedirectResponse
    {
        return redirect('/login')->withErrors([
            'email' => 'El registro está cerrado. Pide a un administrador que cree tu cuenta.',
        ]);
    }
}
