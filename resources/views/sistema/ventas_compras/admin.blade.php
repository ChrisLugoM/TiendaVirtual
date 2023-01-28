@extends('plantillas/menu')
@section('title_pagina', 'Ventas-Compras')
@section('enlaces')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.bootstrap5.min.css') }}">
@endsection
@section('contenido')
    <div class="card" style="">
        <h5 class="card-header bg-success"><b style="color: floralwhite">Ventas-Compras</b></h5>
        <div class="card-body">
            <h5 class="card-title text-center"><b style="color: darkgreen">Listado de Ventas-Compras</b></h5>
            <p><a href="{{ route('tienda.admin') }}" class="btn btn-primary"><i class="fas fa-user-plus">Agregar</i></a>
            </p>
            <div class="table table-responsive">
                <table class="table table-sm table-bordered" id="tabla_registros" style="width: 100%;">
                    <thead>
                        <th>Id</th>
                        <th>No Orden</th>
                        <th>Estatus</th>
                        <th>Usuario</th>
                        <th>Total</th>
                        <th>Fecha</th>
                        <th>Mostrar</th>
                    </thead>
                    <tbody>
                        @foreach ($ventas as $item)
                            <tr>
                                <td>{{ $item->id_venta }}</td>
                                <td>{{ $item->OrdenID }}</td>
                                @if ($item->estatus_venta == 'COMPLETED')
                                    <td>
                                        <p style="color: green;font-weight: bold">
                                            {{ $item->estatus_venta }}</p>
                                    </td>
                                @else
                                    <td>
                                        <p style="color: red;font-weight: bold">{{ $item->estatus_venta }}</p>
                                    </td>
                                @endif
                                <td>{{ $item->user }}</td>
                                <td>${{ $item->total_venta }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <form action="{{ route('ventas.detalles', $item->id_venta) }}" method="GET"><button
                                            class="btn btn-info btn-sm"><i class="fas fa-user-edit">Ver Compra</i></button>
                                    </form>
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
