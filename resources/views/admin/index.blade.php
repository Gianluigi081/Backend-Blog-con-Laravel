@extends('adminlte::page')

@section('title', 'Panel de administración')

@section('content_header')
    <h1>Bienvenidos al panel de administración</h1>
@stop

@section('content')
    <p>¡Hola! {{ Auth::user()->full_name }} desde aquí podrás administrar
    tus artículos, categorías y comentarios.</p>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop