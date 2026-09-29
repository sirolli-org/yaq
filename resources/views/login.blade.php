@extends('components/layout')

@section('title', 'Iniciar sesión')

@section('content')
    <div class="card card--narrow">
        <h1>Iniciar sesión</h1>

        <form method="POST" action="/login">
            @csrf

            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus>

            <label for="password">Contraseña</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required>

            <button type="submit" class="btn">Entrar</button>
        </form>

        <p style="margin: 1.25rem 0 0; font-size: 0.9375rem;">
            ¿No tienes cuenta? <a href="/register">Regístrate</a>
        </p>
    </div>
@endsection
