<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        @vite(['resources/css/tailwind.css'])
    @endif
</head>

<body>
    <div>
        <main role="main">
            <div>
                <img src="{{ asset('yaq-logo.svg') }}" alt="Logo de YAQ" class="w-64 h-auto">
            </div>

            <div class="mt-6">
                <button class="register-btn">Crear Cuenta</button>
            </div>

            <div class="mt-4">
                <button class="login-btn">Iniciar Sesión</button>
            </div>
        </main>
    </div>

</body>

</html>
