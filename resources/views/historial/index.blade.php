@extends('components/layout')

@section('title', 'Historial')

@section('content')
    <div class="page-header">
        <h1>Historial</h1>
    </div>

    <div class="card card--flush">
        <form class="toolbar" method="GET" action="{{ route('historial.index') }}">
            <select name="causa" onchange="this.form.submit()">
                <option value="">Todas las causas</option>
                @foreach ($causas as $c)
                    <option value="{{ $c }}" @selected(request('causa') === $c)>{{ str_replace('_', ' ', ucfirst($c)) }}</option>
                @endforeach
            </select>

            @if (request('causa'))
                <a class="btn btn--ghost" href="{{ route('historial.index') }}">Limpiar</a>
            @endif
        </form>

        @if ($entradas->isEmpty())
            <div class="empty">
                <h3>Sin registros</h3>
                <p>No hay entradas en el historial.</p>
            </div>
        @else
            <div class="table-wrap">
                <table class="table--stack">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Producto</th>
                            <th>Causa</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entradas as $e)
                            <tr>
                                <td data-label="Fecha" class="nowrap">{{ $e->fecha_cambio->timezone('America/Argentina/Buenos_Aires')->format('d/m/Y H:i') }}</td>
                                <td data-label="Usuario">{{ $e->usuario?->name ?? '—' }}</td>
                                <td data-label="Producto">{{ $e->producto?->nombre ?? '—' }}</td>
                                <td data-label="Causa"><span class="badge">{{ str_replace('_', ' ', $e->causa) }}</span></td>
                                <td data-label="Descripción">{{ $e->descripcion }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{ $entradas->links() }}
@endsection
