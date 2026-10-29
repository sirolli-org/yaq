<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['venta_id', 'producto_id', 'precio_venta', 'unidades', 'descuento'])]
class DetalleVenta extends Model
{
    protected $table = 'detalle_ventas';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'precio_venta' => 'decimal:2',
            'unidades' => 'integer',
            'descuento' => 'decimal:2',
        ];
    }

    public function venta(): BelongsTo
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function subtotal(): float
    {
        $bruto = (float) $this->precio_venta * $this->unidades;

        return round($bruto * (1 - (float) $this->descuento / 100), 2);
    }
}
