@extends('components/layout')

@section('title', 'Ventas')

@section('content')
    <div class="page-header">
        <h1>Ventas</h1>
        <div class="actions">
            <a class="btn" href="{{ route('ventas.create') }}">Nueva venta</a>
        </div>
    </div>

    <div class="card card--flush">
        @if ($ventas->isEmpty())
            <div class="empty">
                <h3>No hay ventas</h3>
                <p>Todavía no se registró ninguna venta.</p>
            </div>
        @else
            <div class="table-wrap">
                <table class="table--stack">
                    <thead>
                        <tr>
                            <th>N.º</th>
                            <th>Fecha</th>
                            <th class="num">Productos</th>
                            <th class="num">Total</th>
                            <th>Observaciones</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventas as $v)
                            <tr>
                                <td data-label="N.º">#{{ $v->id }}</td>
                                <td data-label="Fecha">{{ $v->fecha_venta->timezone('America/Argentina/Buenos_Aires')->format('d/m/Y H:i') }}</td>
                                <td data-label="Productos" class="num">{{ $v->detalles->count() }}</td>
                                <td data-label="Total" class="num">$ {{ number_format($v->total(), 2, ',', '.') }}</td>
                                <td data-label="Observaciones">{{ \Illuminate\Support\Str::limit($v->observaciones, 50) ?: '—' }}</td>
                                <td class="actions">
                                    <a class="btn btn--ghost btn--sm" href="{{ route('ventas.show', $v) }}">Ver</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{ $ventas->links() }}
@endsection
