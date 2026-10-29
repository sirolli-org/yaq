<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['observaciones'])]
class Venta extends Model
{
    protected $table = 'ventas';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'fecha_venta' => 'datetime',
        ];
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleVenta::class, 'venta_id');
    }

    public function total(): float
    {
        return round($this->detalles->sum(fn (DetalleVenta $d) => $d->subtotal()), 2);
    }
}
