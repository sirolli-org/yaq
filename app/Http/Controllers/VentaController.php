<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use App\Models\Historial;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('detalles')
            ->orderByDesc('fecha_venta')
            ->orderByDesc('id')
            ->paginate(15);

        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        $productos = Producto::where('unidades', '>', 0)->orderBy('nombre')->get();

        return view('ventas.create', compact('productos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'observaciones' => ['nullable', 'string', 'max:2000'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.producto_id' => ['required', 'integer', 'exists:productos,id'],
            'items.*.unidades' => ['required', 'integer', 'min:1'],
            'items.*.descuento' => ['nullable', 'numeric', 'between:0,100'],
        ], [
            'items.required' => 'Agrega al menos un producto.',
        ]);

        $ids = array_column($data['items'], 'producto_id');

        if (count($ids) !== count(array_unique($ids))) {
            throw ValidationException::withMessages([
                'items' => 'No repitas el mismo producto en la venta.',
            ]);
        }

        $venta = DB::transaction(function () use ($data) {
            $venta = Venta::create(['observaciones' => $data['observaciones'] ?? null]);

            foreach ($data['items'] as $i => $item) {
                $producto = Producto::lockForUpdate()->findOrFail($item['producto_id']);

                if ($producto->unidades < $item['unidades']) {
                    throw ValidationException::withMessages([
                        "items.$i.unidades" => "Stock insuficiente de «{$producto->nombre}» (disponibles: {$producto->unidades}).",
                    ]);
                }

                $descuento = (float) ($item['descuento'] ?? 0);

                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $producto->id,
                    'precio_venta' => $producto->precio_unitario,
                    'unidades' => $item['unidades'],
                    'descuento' => $descuento,
                ]);

                $producto->decrement('unidades', $item['unidades']);

                Historial::create([
                    'usuario_id' => auth()->id(),
                    'producto_id' => $producto->id,
                    'causa' => 'venta',
                    'descripcion' => "Venta #{$venta->id}: {$item['unidades']} u. de «{$producto->nombre}»"
                        . ($descuento > 0 ? " con {$descuento}% de descuento" : '')
                        . ". Stock restante: " . ($producto->unidades - $item['unidades']) . '.',
                ]);
            }

            return $venta;
        });

        return redirect()->route('ventas.show', $venta)->with('status', 'Venta registrada.');
    }

    public function show(Venta $venta)
    {
        $venta->load('detalles.producto');

        return view('ventas.show', compact('venta'));
    }
}
