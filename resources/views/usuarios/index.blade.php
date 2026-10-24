@extends('components/layout')

@section('title', 'Usuarios')

@section('content')
    <div class="page-header">
        <h1>Usuarios</h1>
        <div class="actions">
            <a class="btn" href="{{ route('usuarios.create') }}">Crear usuario</a>
        </div>
    </div>

    <div class="card card--flush">
        <div class="table-wrap">
            <table class="table--stack">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Último acceso</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $u)
                        <tr>
                            <td data-label="Nombre">{{ $u->name }}</td>
                            <td data-label="Correo">{{ $u->email }}</td>
                            <td data-label="Rol">{{ ucfirst($u->rol) }}</td>
                            <td data-label="Estado">
                                <span class="badge {{ $u->estado ? 'badge--ok' : 'badge--out' }}">
                                    {{ $u->estado ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td data-label="Último acceso">{{ $u->ultimo_acceso?->format('d/m/Y H:i') ?? '—' }}</td>
                            <td class="actions">
                                @unless ($u->is(auth()->user()))
                                    <form method="POST" action="{{ route('usuarios.estado', $u) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn--ghost btn--sm">
                                            {{ $u->estado ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>
                                @endunless
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{ $usuarios->links() }}
@endsection
