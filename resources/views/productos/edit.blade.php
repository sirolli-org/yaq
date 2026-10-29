@extends('components/layout')

@section('title', 'Editar producto')

@section('content')
    <div class="page-header">
        <h1>Editar producto</h1>
    </div>

    <form class="card" method="POST" action="{{ route('productos.update', $producto) }}">
        @csrf
        @method('PUT')
        @include('productos._form', ['boton' => 'Guardar cambios'])
    </form>
@endsection
