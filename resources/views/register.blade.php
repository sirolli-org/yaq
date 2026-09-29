@extends('components/layout')

@section('title', 'Registro')

@section('content')
    <div class="card card--narrow">
        <h1>Crear cuenta</h1>

        <form method="POST" action="/register">
            @csrf

            <label for="name">Nombre</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" required autofocus>

            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required>

            <label for="password">Contraseña</label>
            <input id="password" name="password" type="password" autocomplete="new-password" required>

            <label for="password_confirmation">Confirmar contraseña</label>
            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required>

            <button type="submit" class="btn">Crear cuenta</button>
        </form>

        <p style="margin: 1.25rem 0 0; font-size: 0.9375rem;">
            ¿Ya tienes cuenta? <a href="/login">Inicia sesión</a>
        </p>
    </div>
@endsection
