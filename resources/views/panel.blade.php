@extends('components/layout')

@section('title', 'Panel')

@section('content')
    <div class="page-header">
        <div>
            <h1>Panel</h1>
            <p>Bienvenido, {{ auth()->user()->name }}.</p>
        </div>

        @if (auth()->user()->esAdministrador())
            <div class="actions">
                <a class="btn btn--ghost" href="{{ route('usuarios.index') }}">Gestionar usuarios</a>
            </div>
        @endif
    </div>
@endsection
