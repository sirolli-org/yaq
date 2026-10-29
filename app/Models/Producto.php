<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nombre', 'unidades', 'precio_unitario', 'descripcion'])]
class Producto extends Model
{
    protected $table = 'productos';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'unidades' => 'integer',
            'precio_unitario' => 'decimal:2',
            'fecha_carga' => 'datetime',
        ];
    }
}
