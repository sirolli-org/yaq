@extends('components/layout')

@section('title', 'Nueva venta')

@section('content')
    <div class="page-header">
        <h1>Nueva venta</h1>
    </div>

    <form class="card" method="POST" action="{{ route('ventas.store') }}" id="venta-form">
        @csrf

        <div id="items"></div>

        <button type="button" class="btn btn--ghost btn--sm" id="agregar" style="margin-bottom: 1.25rem;">
            + Agregar producto
        </button>

        <label for="observaciones">Observaciones (opcional)</label>
        <textarea id="observaciones" name="observaciones">{{ old('observaciones') }}</textarea>

        <div class="form-actions" style="align-items: center;">
            <strong style="margin-right: auto;">Total: <span id="total">$ 0,00</span></strong>
            <a class="btn btn--ghost" href="{{ route('ventas.index') }}">Cancelar</a>
            <button type="submit" class="btn">Registrar venta</button>
        </div>
    </form>

    <template id="item-template">
        <div class="item-row">
            <div class="item-row__producto">
                <label>Producto</label>
                <select name="items[__I__][producto_id]" required>
                    <option value="">Selecciona…</option>
                    @foreach ($productos as $p)
                        <option value="{{ $p->id }}" data-precio="{{ $p->precio_unitario }}" data-stock="{{ $p->unidades }}">
                            {{ $p->nombre }} — $ {{ number_format($p->precio_unitario, 2, ',', '.') }} ({{ $p->unidades }} disp.)
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Unidades</label>
                <input type="number" name="items[__I__][unidades]" min="1" step="1" value="1" required>
            </div>
            <div>
                <label>Descuento %</label>
                <input type="number" name="items[__I__][descuento]" min="0" max="100" step="0.01" value="0">
            </div>
            <div>
                <button type="button" class="btn btn--danger btn--sm item-row__quitar">Quitar</button>
            </div>
        </div>
    </template>
@endsection

@push('styles')
<style>
    .item-row {
        display: grid;
        grid-template-columns: minmax(0, 3fr) minmax(0, 1fr) minmax(0, 1fr) auto;
        gap: 0 1rem;
        align-items: end;
        padding-bottom: 0.25rem;
        border-bottom: 1px solid var(--border);
        margin-bottom: 1rem;
    }
    .item-row .btn { margin-bottom: 1rem; }
    @media (max-width: 720px) {
        .item-row { grid-template-columns: 1fr 1fr; }
        .item-row__producto { grid-column: 1 / -1; }
    }
</style>
@endpush

@push('scripts')
@php
    $itemsIniciales = old('items', [['producto_id' => '', 'unidades' => 1, 'descuento' => 0]]);
@endphp
<script>
    (() => {
        const contenedor = document.getElementById('items');
        const plantilla = document.getElementById('item-template');
        const totalEl = document.getElementById('total');
        const previos = @json($itemsIniciales);
        let indice = 0;

        const formato = (n) => '$ ' + n.toLocaleString('es-AR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

        const recalcular = () => {
            let total = 0;
            contenedor.querySelectorAll('.item-row').forEach((fila) => {
                const opcion = fila.querySelector('select').selectedOptions[0];
                const precio = parseFloat(opcion?.dataset.precio || 0);
                const unidades = parseInt(fila.querySelector('[name$="[unidades]"]').value || 0, 10);
                const descuento = parseFloat(fila.querySelector('[name$="[descuento]"]').value || 0);
                total += precio * unidades * (1 - descuento / 100);
            });
            totalEl.textContent = formato(total);
        };

        const agregar = (valores = {}) => {
            const html = plantilla.innerHTML.replaceAll('__I__', indice++);
            const envoltorio = document.createElement('div');
            envoltorio.innerHTML = html.trim();
            const fila = envoltorio.firstElementChild;

            fila.querySelector('select').value = valores.producto_id ?? '';
            fila.querySelector('[name$="[unidades]"]').value = valores.unidades ?? 1;
            fila.querySelector('[name$="[descuento]"]').value = valores.descuento ?? 0;

            fila.querySelector('select').addEventListener('change', (e) => {
                const stock = e.target.selectedOptions[0]?.dataset.stock;
                if (stock) fila.querySelector('[name$="[unidades]"]').max = stock;
                recalcular();
            });
            fila.querySelectorAll('input').forEach((i) => i.addEventListener('input', recalcular));
            fila.querySelector('.item-row__quitar').addEventListener('click', () => {
                if (contenedor.children.length > 1) {
                    fila.remove();
                    recalcular();
                }
            });

            contenedor.appendChild(fila);
            recalcular();
        };

        document.getElementById('agregar').addEventListener('click', () => agregar());
        previos.forEach((v) => agregar(v));
    })();
</script>
@endpush
