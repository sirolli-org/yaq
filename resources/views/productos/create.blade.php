@extends('components/layout')

@section('title', 'Crear producto')

@section('content')
    <div class="page-header">
        <h1>Crear producto</h1>
    </div>

    <form class="card" method="POST" action="{{ route('productos.store') }}">
        @csrf
        @include('productos._form', ['boton' => 'Crear producto'])
    </form>
@endsection
