<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private function autorizar(): void
    {
        abort_unless(auth()->user()->esAdministrador(), 403);
    }

    public function index()
    {
        $this->autorizar();

        return view('usuarios.index', [
            'usuarios' => User::orderBy('name')->paginate(15),
        ]);
    }

    public function create()
    {
        $this->autorizar();

        return view('usuarios.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->autorizar();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'rol' => ['required', Rule::in(['administrador', 'empleado'])],
        ]);

        $user = new User($data);
        $user->rol = $data['rol'];
        $user->save();

        return redirect()->route('usuarios.index')->with('status', 'Usuario creado.');
    }

    public function toggleEstado(User $user): RedirectResponse
    {
        $this->autorizar();

        // Un administrador no puede desactivarse a sí mismo
        abort_if($user->is(auth()->user()), 422);

        $user->estado = ! $user->estado;
        $user->save();

        return back()->with('status', 'Estado actualizado.');
    }
}
