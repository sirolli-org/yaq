@extends('components/layout')

@section('title', 'Crear usuario')

@section('content')
    <div class="page-header">
        <h1>Crear usuario</h1>
    </div>

    <form class="card" method="POST" action="{{ route('usuarios.store') }}">
        @csrf

        <div class="form-grid">
            <div>
                <label for="name">Nombre de usuario</label>
                <input id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div>
                <label for="email">Correo</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required>
            </div>

            <div>
                <label for="password">Contraseña</label>
                <input id="password" name="password" type="password" required>
            </div>

            <div>
                <label for="password_confirmation">Repetir contraseña</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required>
            </div>

            <div class="full">
                <label for="rol">Rol</label>
                <select id="rol" name="rol">
                    <option value="empleado" @selected(old('rol', 'empleado') === 'empleado')>Empleado</option>
                    <option value="administrador" @selected(old('rol') === 'administrador')>Administrador</option>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <a class="btn btn--ghost" href="{{ route('usuarios.index') }}">Cancelar</a>
            <button type="submit" class="btn">Crear usuario</button>
        </div>
    </form>
@endsection
