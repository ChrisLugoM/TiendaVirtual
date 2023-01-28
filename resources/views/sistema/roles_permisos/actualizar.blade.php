@extends('plantillas/menu')
@section('title_pagina', 'Roles Actualizar')
@section('enlaces')
    <link rel="stylesheet" href="{{ asset('css/form_admin.css') }}">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
@section('contenido')
    <div class="card">
        <div class="card-header">
            <h3 style="color: slateblue;font-weight: bold;text-align: center">Actualizar Rol de Usuario</h3>
        </div>
        <div class="card-body">
            <div class="container">
                <form action="{{ route('rol_admin.update', $role->id) }}" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="p-1 bg-light">
                        <label class="fw-bold">Nombre del Rol:</label>
                        <input type="text" class="form-control" name="nombre" value="{{ $role->nombre }}">
                    </div>
                    <div class="p-1 bg-light">
                        <label class="fw-bold">Descripcion:</label>
                        <input type="text" class="form-control" name="desc" value="{{ $role->descripcion }}">
                    </div>
                    <div class="p-2 bg-light">
                        <a href="{{ route('rol_admin') }}" class="btn btn-dark"><i
                                class="fas fa-undo-alt">Regresar</i></a>
                        <button type="submit" id="btn_guardar" class="btn btn-primary"><i
                                class="fas fa-user-plus">Actualizar</i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/validacion.js') }}"></script>
@endsection
