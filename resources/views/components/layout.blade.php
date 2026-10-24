<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'YAQ') · YAQ</title>
    <link rel="icon" href="/favicon.ico" type="image/svg+xml">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body>
    <header class="site-header">
        <div class="inner">
            <a href="/" class="brand" aria-label="YAQ, ir al inicio">
                <img src="/yaq-logo.svg" alt="Logo de YAQ">
            </a>

            <nav class="nav" aria-label="Navegación principal">
                <a href="/" @if (request()->is('/')) aria-current="page" @endif>Inicio</a>

                @auth
                    <a href="/panel" @if (request()->is('panel')) aria-current="page" @endif>Panel</a>

                    @if (auth()->user()->esAdministrador())
                        <a href="{{ route('usuarios.index') }}" @if (request()->is('usuarios*')) aria-current="page" @endif>Usuarios</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn--danger btn--sm">Cerrar sesión</button>
                    </form>

                @else
                    <a href="/login" @if (request()->is('login')) aria-current="page" @endif>Iniciar sesión</a>

                    @if (\App\Models\User::doesntExist())
                        <a href="/register" @if (request()->is('register')) aria-current="page" @endif>Registrarse</a>
                    @endif
                @endauth
            </nav>
        </div>
    </header>

    <main class="site-main">
        @if (session('status'))
            <div class="alert alert--success" role="status">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert--error" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="inner">
            © {{ date('Y') }} YAQ - Yet Another Quiosco
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
