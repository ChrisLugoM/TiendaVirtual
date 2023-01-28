@extends('plantillas/menu')
@section('title_pagina', 'Administracion Agregar')
@section('enlaces')
    <link rel="stylesheet" href="{{ asset('css/form_admin.css') }}">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
@section('contenido')
    <div class="card">
        <div class="card-header">
            <h3 style="color: slateblue;font-weight: bold;text-align: center">Agregar registro de Usuario</h3>
        </div>
        <div class="card-body">
            <div class="container">
                <form action="{{ route('usuario.add') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="p-1 bg-light">
                        <label class="fw-bold">Nombre del Empleado:</label>
                        <input type="text" class="form-control" name="nombre" placeholder="Nombre del empleado">
                    </div>
                    <div class="p-1 bg-light">
                        <label class="fw-bold">Apellidos:</label>
                        <input type="text" class="form-control" name="apellidos" placeholder="Apellidos">
                    </div>
                    <div class="p-1 bg-light">
                        <label class="fw-bold">Fecha de nacimiento:</label>
                        <input type="date" class="form-control" name="fnac">
                    </div>
                    <div class="p-1 bg-light">
                        <label class="fw-bold">Correo Electronico:</label>
                        <input type="email" class="form-control" name="email" placeholder="Correo Electronico">
                    </div>
                    <div class="p-1 bg-light">
                        <label class="fw-bold">Usuario:</label>
                        <input type="text" class="form-control" name="usuario" placeholder="Nombre de usuario">
                    </div>
                    <div class="p-1 bg-light">
                        <label class="fw-bold">Clave del usuario:</label>
                        <input type="password" class="form-control" id="password_uno" name="password_uno"
                            placeholder="Contraseña"><span class="fa fa-fw fa-eye password-icon"
                            onclick="ver_clave()"></span>
                    </div>
                    <div class="p-1 bg-light">
                        <label class="fw-bold">Confirmar Clave:</label>
                        <input type="password" class="form-control" id="password_dos" name="password_dos"
                            onblur="validar_clave()" placeholder="Confirma la contraseña">
                    </div>
                    <div class="p-1 bg-light">
                        <label class="fw-bold">Tipo de Usuario:</label>
                        <select name="tipo" required>
                            <option value="">Selecciona una opcion</option>
                            @foreach ($role as $item)
                                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="p-2 bg-light">
                        <a href="{{ route('admin') }}" class="btn btn-dark"><i class="fas fa-undo-alt">Regresar</i></a>
                        <button type="reset" class="btn btn-info"><i class="fas fa-broom">Vaciar</i></button>
                        <button type="submit" id="btn_guardar" class="btn btn-primary"><i
                                class="fas fa-user-plus">Guardar</i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/validacion.js') }}"></script>
@endsection
