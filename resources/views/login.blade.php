<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
</head>

<body>
    <img src="/yaq-logo.svg" alt="Logo de YAQ">
    <h1>Iniciar sesión</h1>

    <nav>
        <ul>
            <li><a href="/">Inicio</a></li>
            <li>Iniciar sesión</li>
            <li><a href="/register">Registrarse</a></li>
        </ul>
    </nav>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="/login">
        @csrf

        <div>
            <label for="email">Email:</label><br>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <label for="password">Password:</label><br>
            <input id="password" name="password" type="password" required>
        </div>

        <div>
            <button type="submit">Entrar</button>
        </div>
    </form>
</body>

</html>
