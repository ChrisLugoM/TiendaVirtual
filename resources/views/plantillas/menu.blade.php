<!DOCTYPE html>
<html lang="en">
<link rel="icon" href="{{ asset('img/sistema.png') }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title_pagina')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    @yield('enlaces')
</head>
<style>
    body {
        background-image: url('img/tecno.jpg');
        background-repeat: no-repeat;
        background-size: 100%;
        background-position-y: 50px;
        background-size: 100% 550px;
        margin: 0;
        margin-bottom: 40px;
    }

    nav {
        font-weight: 600;
    }

    .dropdown a {
        background-color: #e3f2fd;
    }

    footer {
        background-color: black;
        position: fixed;
        bottom: 0;
        width: 100%;
        height: 50px;
        color: white;
        text-align: center;
    }

    .nombre_usuario {
        position: relative;
    }

</style>

<body>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Menu</a>
            <!--<button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>-->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                    @endguest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('menu_principal') }}">Inicio</a>
                    </li>
                    @can('productos')
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">Productos</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ url('productos') }}">
                                        Registros</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ url('tienda') }}">
                                        Tienda</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ url('ventas') }}">
                                        Ventas</a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                    @can('admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Administracion
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ url('administracion') }}">
                                        Usuarios</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ url('roles') }}">
                                        Permisos</a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <form action="/logout" method="post">
                                @csrf
                                <li><a class="dropdown-item" href="#" onclick="this.closest('form').submit()">Cerrar
                                        Sesion</a>
                                </li>
                            </form>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @yield('contenido')
</body>
<footer>
    Pruebas
</footer>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
@yield('js')

</html>
