@extends('plantillas/layout')
@section('title_pagina', 'Inicio')
@section('contenido')
    <div class="m-4">
        <div class="container text-center col-sm-5">
            <div class="modal-content" style="background: papayawhip">
                <div class="col-12 user-img">
                    <img src="img/login.png" width="100">
                </div>
                <form action="{{ route('login.show') }}" method="POST" autocomplete="off">
                    @csrf
                    @method('POST')
                    <div class="form-group m-1">
                        <input type="text" class="form-control" name="usuario" placeholder="Usuario" required>
                    </div>
                    <div class="form-group m-1">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <div class="container m-2">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Iniciar
                                    Sesion</button><br>
                            </div>
                            <div class="col">
                                <a href="http://" class="btn btn-info"><i class="far fa-flushed">Recuperar Clave</i></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
