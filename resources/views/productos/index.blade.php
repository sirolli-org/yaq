@extends('components/layout')

@section('title', 'Productos')

@section('content')
    <div class="page-header">
        <h1>Productos</h1>

        @if (auth()->user()->esAdministrador())
            <div class="actions">
                <a class="btn" href="{{ route('productos.create') }}">Crear producto</a>
            </div>
        @endif
    </div>

    <div class="card card--flush">
        <form class="toolbar" method="GET" action="{{ route('productos.index') }}">
            <input class="grow" type="search" name="q" value="{{ request('q') }}" placeholder="Buscar producto…">
            <button type="submit" class="btn btn--ghost">Buscar</button>

            @if (request('q'))
                <a class="btn btn--ghost" href="{{ route('productos.index') }}">Limpiar</a>
            @endif
        </form>

        @if ($productos->isEmpty())
            <div class="empty">
                <h3>No hay productos</h3>
                <p>{{ request('q') ? 'Ningún producto coincide con la búsqueda.' : 'Todavía no se cargó ningún producto.' }}</p>
            </div>
        @else
            <div class="table-wrap">
                <table class="table--stack">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th class="num">Unidades</th>
                            <th class="num">Precio unitario</th>
                            <th>Estado</th>
                            <th>Fecha de carga</th>
                            @if (auth()->user()->esAdministrador())
                                <th></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $p)
                            <tr>
                                <td data-label="Nombre">
                                    {{ $p->nombre }}
                                    @if ($p->descripcion)
                                        <div class="muted" style="font-size: .8125rem;">{{ \Illuminate\Support\Str::limit($p->descripcion, 70) }}</div>
                                    @endif
                                </td>
                                <td data-label="Unidades" class="num">{{ $p->unidades }}</td>
                                <td data-label="Precio unitario" class="num">$ {{ number_format($p->precio_unitario, 2, ',', '.') }}</td>
                                <td data-label="Estado">
                                    @if ($p->unidades === 0)
                                        <span class="badge badge--out">Sin stock</span>
                                    @elseif ($p->unidades <= 5)
                                        <span class="badge badge--low">Stock bajo</span>
                                    @else
                                        <span class="badge badge--ok">En stock</span>
                                    @endif
                                </td>
                                <td data-label="Fecha de carga">
                                    {{ $p->fecha_carga?->timezone('America/Argentina/Buenos_Aires')->format('d/m/Y H:i') }}
                                </td>
                                @if (auth()->user()->esAdministrador())
                                    <td class="actions">
                                        <a class="btn btn--ghost btn--sm" href="{{ route('productos.edit', $p) }}">Editar</a>

                                        <form method="POST" action="{{ route('productos.destroy', $p) }}"
                                              onsubmit="return confirm('¿Eliminar «{{ addslashes($p->nombre) }}»?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn--danger btn--sm">Eliminar</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{ $productos->links() }}
@endsection
