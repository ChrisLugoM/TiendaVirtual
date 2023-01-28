@extends('plantillas/menu')
@section('title_pagina', 'Productos')
@section('enlaces')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.bootstrap5.min.css') }}">
@endsection
@section('contenido')
    <div class="card" style="">
        <h5 class="card-header bg-secondary">Productos</h5>
        <div class="card-body">
            <h5 class="card-title text-center text-success"><b>Listado de Productos Registrados</b></h5>
            <p><a href="{{ route('product.add') }}" class="btn btn-primary"><i class="fas fa-user-plus">Agregar</i></a>
            </p>
            <div class="table table-responsive">
                <table class="table table-sm table-bordered" id="tabla_registros" style="width: 100%;">
                    <thead>
                        <th>Id</th>
                        <th>Codigo</th>
                        <th>N. Producto</th>
                        <th>Img</th>
                        <th>Existencia</th>
                        <th>Marca</th>
                        <th>Creado</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </thead>
                    <tbody>
                        @foreach ($product as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->codigo }}</td>
                                <td>{{ $item->nombre_prod }}</td>
                                <td><img src="{{ asset('img_productos/' . $item->usuario . '/' . $item->nombre_img) }}"
                                        width="100px">
                                </td>
                                <td>{{ $item->existencia }}</td>
                                <td>{{ $item->marca }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <form action="{{ route('product.edit', $item->id) }}" method="GET"><button
                                            class="btn btn-info btn-sm"><i class="fas fa-user-edit"></i></button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('product.delete', $item->id) }}" method="GET"><button
                                            class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button></form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript" src="{{ asset('js/jquery-3.5.1.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/responsive.bootstrap5.min.js') }}"></script>
    <script style="text/javascript">
        $(document).ready(function() {
            $('#tabla_registros').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    search: "Buscar:",
                    zeroRecords: "No existe registro",
                    info: "Mostrando _START_ de _END_ , Total de Registros: _TOTAL_",
                    lengthMenu: "Mostrar _MENU_ registros",
                    paginate: {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            })
        });
    </script>
@endsection
