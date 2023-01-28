@extends('plantillas/menu')
@section('title_pagina', 'Inicio')
@section('contenido')
    <div class="container"><br>
        <h1><span class="nombre_usuario"><b>Bienvenido {{ auth()->user()->name }}</b></span></h1>
    </div>
@endsection
