@extends('plantillas/menu')
@section('title_pagina', 'Administracion Actualizar')
@section('enlaces')
    <link rel="stylesheet" href="{{ asset('css/form_admin.css') }}">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
@section('contenido')
    <div class="card">
        <div class="card-header">
            <h3 style="color: slateblue;font-weight: bold;text-align: center">Actualizar registro de Usuario</h3>
        </div>
        <div class="card-body">
            <div class="container">
                <form action="{{ route('usuario.update', $usuario->id) }}" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="p-1 bg-light">
                        <label class="fw-bold">Nombre del Empleado:</label>
                        <input type="text" class="form-control" name="nombre" value="{{ $usuario->name }}">
                    </div>
                    <div class="p-1 bg-light">
                        <label class="fw-bold">Apellidos:</label>
                        <input type="text" class="form-control" name="apellidos" value="{{ $usuario->last_name }}">
                    </div>
                    <div class="p-1 bg-light">
                        <label class="fw-bold">Fecha de nacimiento:</label>
                        <input type="date" class="form-control" name="fnac" value="{{ $usuario->fecha_nac }}">
                    </div>
                    <div class="p-1 bg-light">
                        <label class="fw-bold">Correo Electronico:</label>
                        <input type="email" class="form-control" name="email" value="{{ $usuario->email }}">
                    </div>
                    <div class="p-1 bg-light">
                        <label class="fw-bold">Usuario:</label>
                        <input type="text" class="form-control" name="usuario" value="{{ $usuario->usuario }}">
                    </div>
                    <div class="p-1 bg-light">
                        <label class="fw-bold">Clave del usuario:</label>
                        <input type="password" class="form-control" id="password_uno" name="password_uno"
                            value="{{ $decrypted = Crypt::decrypt($usuario->password) }}"><span
                            class="fa fa-fw fa-eye password-icon" onclick="ver_clave()"></span>
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
                                <option
                                    @if ($reg_role->role_id == $item->id) value="{{ $reg_role->role_id }}" selected @else
                                    value="{{ $item->id }}" @endif>
                                    {{ $item->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="p-2 bg-light">
                        <a href="{{ route('admin') }}" class="btn btn-dark"><i class="fas fa-undo-alt">Regresar</i></a>
                        <button type="submit" id="btn_guardar" class="btn btn-primary"><i
                                class="fas fa-user-plus">Actualizar</i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/validacion.js') }}"></script>
@endsection
