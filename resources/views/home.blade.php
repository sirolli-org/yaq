@extends('components/layout')

@section('title', 'Inicio')

@section('content')
    <section class="hero">
        <h1>Gestiona tu quiosco sin complicaciones</h1>
        <p>
            YAQ (Yet Another Quiosco) es un sistema sencillo para controlar tu stock,
            registrar ventas y llevar el seguimiento de cada cambio en un solo lugar.
        </p>

        <div class="hero__actions">
            @auth
                <a class="btn" href="{{ route('panel') }}">Ir al panel</a>
            @else
                <a class="btn" href="{{ route('login') }}">Iniciar sesión</a>

                @if (\App\Models\User::doesntExist())
                    <a class="btn btn--ghost" href="{{ route('register') }}">Crear cuenta de administrador</a>
                @endif
            @endauth
        </div>
    </section>

    <div class="section-grid">
        <div class="card">
            <span class="section-card__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 8l-9-5-9 5 9 5 9-5z"/>
                    <path d="M3 8v8l9 5 9-5V8"/>
                    <path d="M12 13v8"/>
                </svg>
            </span>
            <h2 class="section-card__title">Control de stock</h2>
            <p class="section-card__text">Carga tus productos con su precio y cantidad, y detecta de un vistazo cuáles tienen poco stock o se agotaron.</p>
        </div>

        <div class="card">
            <span class="section-card__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="21" r="1"/>
                    <circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                </svg>
            </span>
            <h2 class="section-card__title">Ventas</h2>
            <p class="section-card__text">Registra cada venta con sus productos y descuentos. El stock se descuenta automáticamente.</p>
        </div>

        <div class="card">
            <span class="section-card__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M12 7v5l3 2"/>
                </svg>
            </span>
            <h2 class="section-card__title">Historial</h2>
            <p class="section-card__text">Cada alta, modificación y venta queda registrada con su fecha y el usuario que la realizó.</p>
        </div>

        <div class="card">
            <span class="section-card__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"/>
                    <circle cx="10" cy="7" r="4"/>
                    <path d="M21 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M17 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </span>
            <h2 class="section-card__title">Usuarios y roles</h2>
            <p class="section-card__text">Los administradores crean cuentas para el personal y controlan quién puede acceder al sistema.</p>
        </div>
    </div>
@endsection
