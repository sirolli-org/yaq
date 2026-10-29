<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(auth()->user()->esAdministrador(), 403);

        $entradas = Historial::with(['usuario', 'producto'])
            ->when($request->query('causa'), fn ($q, $causa) => $q->where('causa', $causa))
            ->orderByDesc('fecha_cambio')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        $causas = Historial::query()->select('causa')->distinct()->orderBy('causa')->pluck('causa');

        return view('historial.index', compact('entradas', 'causas'));
    }
}
