<div class="form-grid">
    <div class="full">
        <label for="nombre">Nombre</label>
        <input id="nombre" name="nombre" value="{{ old('nombre', $producto->nombre ?? '') }}" required>
    </div>

    <div>
        <label for="unidades">Unidades</label>
        <input id="unidades" name="unidades" type="number" min="0" step="1"
               value="{{ old('unidades', $producto->unidades ?? 0) }}" required>
    </div>

    <div>
        <label for="precio_unitario">Precio unitario</label>
        <input id="precio_unitario" name="precio_unitario" type="number" min="0" step="0.01"
               value="{{ old('precio_unitario', $producto->precio_unitario ?? '') }}" required>
    </div>

    <div class="full">
        <label for="descripcion">Descripción (opcional)</label>
        <textarea id="descripcion" name="descripcion">{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
    </div>
</div>

<div class="form-actions">
    <a class="btn btn--ghost" href="{{ route('productos.index') }}">Cancelar</a>
    <button type="submit" class="btn">{{ $boton }}</button>
</div>
