<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('rol', 30)->default('empleado');
            $table->boolean('estado')->default(true);
            $table->timestamp('ultimo_acceso')->nullable();
        });

        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->unsignedInteger('unidades')->default(0);
            $table->decimal('precio_unitario', 10, 2);
            $table->text('descripcion')->nullable();
            $table->timestamp('fecha_carga')->useCurrent();
        });

        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fecha_venta')->useCurrent();
            $table->text('observaciones')->nullable();
        });

        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')->constrained('ventas')->cascadeOnDelete();
            $table->foreignId('producto_id')->constrained('productos')->restrictOnDelete();
            $table->decimal('precio_venta', 10, 2);
            $table->unsignedInteger('unidades');             // mínimo 1 (ver CHECK más abajo)
            $table->decimal('descuento', 5, 2)->default(0);  // porcentaje: 0 a 100

            $table->unique(['venta_id', 'producto_id']);
        });

        Schema::create('historial', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('producto_id')->nullable()->constrained('productos')->nullOnDelete();
            $table->string('causa', 50);
            $table->text('descripcion');
            $table->timestamp('fecha_cambio')->useCurrent();

            $table->index('causa');
            $table->index('fecha_cambio');
        });

        // SQLite no permite añadir CHECK con ALTER TABLE; en ese caso
        // valida en la aplicación (unidades >= 1, descuento entre 0 y 100).
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('ALTER TABLE detalle_ventas ADD CONSTRAINT chk_detalle_unidades CHECK (unidades >= 1)');
            DB::statement('ALTER TABLE detalle_ventas ADD CONSTRAINT chk_detalle_descuento CHECK (descuento >= 0 AND descuento <= 100)');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('historial');
        Schema::dropIfExists('detalle_ventas');
        Schema::dropIfExists('ventas');
        Schema::dropIfExists('productos');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['rol', 'estado', 'ultimo_acceso']);
        });
    }
};
