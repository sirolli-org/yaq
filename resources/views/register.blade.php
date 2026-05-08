<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>

<body>
    <img src="/yaq-logo.svg" alt="Logo de YAQ">
    <h1>Registrarse</h1>

    <nav>
        <ul>
            <li><a href="/">Inicio</a></li>
            <li><a href="/login">Iniciar sesión</a></li>
            <li>Registrarse</li>
        </ul>
    </nav>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="/register">
        @csrf

        <div>
            <label for="name">Nombre</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required>
        </div>

        <div>
            <label for="email">Email:</label><br>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <label for="password">Password:</label><br>
            <input id="password" name="password" type="password" required>
        </div>

        <div>
            <label for="password_confirmation">Confirmar password:</label><br>
            <input id="password_confirmation" name="password_confirmation" type="password" required>
        </div>

        <div>
            <button type="submit">Crear cuenta</button>
        </div>
    </form>
</body>

</html>
