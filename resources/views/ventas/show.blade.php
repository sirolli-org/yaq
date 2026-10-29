@extends('components/layout')

@section('title', 'Venta #' . $venta->id)

@section('content')
    <div class="page-header">
        <div>
            <h1>Venta #{{ $venta->id }}</h1>
            <p>{{ $venta->fecha_venta->timezone('America/Argentina/Buenos_Aires')->format('d/m/Y H:i') }}</p>
        </div>
        <div class="actions">
            <a class="btn btn--ghost" href="{{ route('ventas.index') }}">Volver</a>
        </div>
    </div>

    @if ($venta->observaciones)
        <div class="card" style="margin-bottom: 1.5rem;">
            <h3>Observaciones</h3>
            <p style="margin: 0;">{{ $venta->observaciones }}</p>
        </div>
    @endif

    <div class="card card--flush">
        <div class="table-wrap">
            <table class="table--stack">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th class="num">Precio</th>
                        <th class="num">Unidades</th>
                        <th class="num">Descuento</th>
                        <th class="num">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($venta->detalles as $d)
                        <tr>
                            <td data-label="Producto">{{ $d->producto->nombre }}</td>
                            <td data-label="Precio" class="num">$ {{ number_format($d->precio_venta, 2, ',', '.') }}</td>
                            <td data-label="Unidades" class="num">{{ $d->unidades }}</td>
                            <td data-label="Descuento" class="num">{{ rtrim(rtrim(number_format($d->descuento, 2, ',', '.'), '0'), ',') }} %</td>
                            <td data-label="Subtotal" class="num">$ {{ number_format($d->subtotal(), 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="num">Total</th>
                        <th class="num">$ {{ number_format($venta->total(), 2, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
