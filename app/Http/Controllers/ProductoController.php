<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use App\Models\Producto;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $productos = Producto::query()
            ->when($request->query('q'), fn ($query, $term) => $query->where('nombre', 'like', "%{$term}%"))
            ->orderBy('nombre')
            ->paginate(15)
            ->withQueryString();

        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $this->autorizar();

        return view('productos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->autorizar();

        $producto = Producto::create($this->validar($request));

        $this->registrar(
            'producto_creado',
            "Producto «{$producto->nombre}» creado con {$producto->unidades} unidades a \${$producto->precio_unitario}.",
            $producto->id
        );

        return redirect()->route('productos.index')->with('status', 'Producto creado.');
    }

    public function edit(Producto $producto)
    {
        $this->autorizar();

        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto): RedirectResponse
    {
        $this->autorizar();

        $producto->fill($this->validar($request));

        if ($producto->isDirty()) {
            $cambios = collect($producto->getDirty())
                ->map(fn ($nuevo, $campo) => "{$campo}: " . ($producto->getOriginal($campo) ?? '—') . ' → ' . ($nuevo ?? '—'))
                ->implode('; ');

            $producto->save();

            $this->registrar('producto_modificado', "Producto «{$producto->nombre}» modificado. {$cambios}", $producto->id);
        }

        return redirect()->route('productos.index')->with('status', 'Producto actualizado.');
    }

    public function destroy(Producto $producto): RedirectResponse
    {
        $this->autorizar();

        $nombre = $producto->nombre;

        try {
            $producto->delete();
        } catch (QueryException) {
            return back()->withErrors([
                'producto' => 'No se puede eliminar un producto que tiene ventas registradas.',
            ]);
        }

        $this->registrar('producto_eliminado', "Producto «{$nombre}» eliminado.");

        return redirect()->route('productos.index')->with('status', 'Producto eliminado.');
    }

    private function validar(Request $request): array
    {
        return $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'unidades' => ['required', 'integer', 'min:0'],
            'precio_unitario' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'descripcion' => ['nullable', 'string', 'max:2000'],
        ]);
    }

    private function autorizar(): void
    {
        abort_unless(auth()->user()->esAdministrador(), 403);
    }

    private function registrar(string $causa, string $descripcion, ?int $productoId = null): void
    {
        Historial::create([
            'usuario_id' => auth()->id(),
            'producto_id' => $productoId,
            'causa' => $causa,
            'descripcion' => $descripcion,
        ]);
    }
}
