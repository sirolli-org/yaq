<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['usuario_id', 'producto_id', 'causa', 'descripcion'])]
class Historial extends Model
{
    protected $table = 'historial';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'fecha_cambio' => 'datetime',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
