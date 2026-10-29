@extends('components/layout')

@section('title', 'Panel')

@section('content')
    <div class="page-header">
        <div>
            <h1>Panel</h1>
            <p>Bienvenido, {{ auth()->user()->name }}.</p>
        </div>
    </div>

    <div class="section-grid">
        <a class="card section-card" href="{{ route('productos.index') }}">
            <span class="section-card__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 8l-9-5-9 5 9 5 9-5z"/>
                    <path d="M3 8v8l9 5 9-5V8"/>
                    <path d="M12 13v8"/>
                </svg>
            </span>
            <h2 class="section-card__title">Productos</h2>
            <p class="section-card__text">Consulta el stock, los precios y la información de cada producto.</p>
        </a>

        <a class="card section-card" href="{{ route('ventas.index') }}">
            <span class="section-card__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="21" r="1"/>
                    <circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                </svg>
            </span>
            <h2 class="section-card__title">Ventas</h2>
            <p class="section-card__text">Registra ventas y revisa el detalle de las operaciones realizadas.</p>
        </a>

        @if (auth()->user()->esAdministrador())
            <a class="card section-card" href="{{ route('historial.index') }}">
                <span class="section-card__icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 7v5l3 2"/>
                    </svg>
                </span>
                <h2 class="section-card__title">Historial</h2>
                <p class="section-card__text">Audita los cambios realizados sobre productos y usuarios.</p>
            </a>

            <a class="card section-card" href="{{ route('usuarios.index') }}">
                <span class="section-card__icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"/>
                        <circle cx="10" cy="7" r="4"/>
                        <path d="M21 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M17 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </span>
                <h2 class="section-card__title">Usuarios</h2>
                <p class="section-card__text">Crea cuentas, asigna roles y activa o desactiva el acceso.</p>
            </a>
        @endif
    </div>
@endsection
