@extends('components/layout')

@section('title', 'Welcome')

@section('content')
    <h1>Ruta protegida</h1>
    <p>Bienvenido, {{ auth()->user()->name ?? 'Guest' }}.</p>
@endsection
