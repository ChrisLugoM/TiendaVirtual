@extends('plantillas/menu')
@section('title_pagina', 'Detalle de Compra')
@section('enlaces')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tienda.css') }}">
@endsection
@section('contenido')
    <div class="card" style="">
        <div class="card-body">
            <div class="">
                <h2 class="card-title text-center text-success"><b>Detalle de la Compra</b></h2><br>
                <div class="row card-body">
                    <div class="col-6" style="float: left"><a href="{{ route('ventas.admin') }}"
                            class="btn btn-dark"><i class="fas fa-undo-alt">Regresar</i></a></div>
                    <div class="col-6">
                        <form action="{{ route('ventas.reporte', $id_venta) }}" method="GET" target="_blank"><button
                                style="float: right;" class="btn btn-success"><i class="fa fa-file"> Reporte</i></button>
                        </form>
                    </div>
                </div>
                <table class="table table-sm table-bordered" id="tabla_registros" style="width: 100%;" border="5">
                    <thead>
                        <tr>
                            <th>Descripcion</th>
                            <th>Producto</th>
                            <th>Precio Unitario</th>
                            <th>Cantidad</th>
                            <th>Precio Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $row)
                            <tr>
                                <td>{{ $row->nombre_prod }}</td>
                                <td class="text-center" width="100px">
                                    <input type="hidden" name="id_prod" value="{{ $row->id }}">
                                    <img src="{{ asset('img_productos/' . $row->usuario . '/' . $row->nombre_img) }}"
                                        width="100%">
                                </td>
                                <td>${{ number_format($row->precio, 2) }}</td>
                                @foreach ($detalle_venta as $venta)
                                    @if ($row->id == $venta->id_producto)
                                        <td>{{ $venta->cantidad }}</td>
                                        <td>${{ number_format($row->precio * $venta->cantidad, 2) }}</td>
                                    @endif
                                @endforeach
                        @endforeach
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"></td>
                            <td>SubTotal</td>
                            <td>${{ number_format($suma_total, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td>IVA 16%</td>
                            @php
                                $total_iva = number_format($suma_total * 0.16, 2);
                            @endphp
                            <td>${{ number_format($total_iva, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td>Total a Pagar</td>
                            @php
                                $total = number_format($total_iva + $suma_total, 2);
                            @endphp
                            <td>${{ $total }}</td>
                        </tr>
                    </tfoot>
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
            $('img').popover();
            orden_tabla();
            /*$(function() {
                var arr = new Array(@json(Cart::getContent()));
                var count = "{{ count(Cart::getContent()) }}";
                for (let index = 0; index < count; index++) {
                    console.log(arr[index]);
                }
                //var cantidad = $('#cant').val();
                console.log(count);
            });
            //console.log(Cart::getContent());*/
            $("select[name=cant]").change(function() {
                var cant = $(this).val();
                var id = $(this).attr('data-content');
                var parametros = {
                    "cantidad": cant,
                    "id": id
                };
                $.ajax({
                    type: "get",
                    url: "/tienda/producto/{cant}",
                    data: parametros,
                    success: function(response) {
                        location.reload();
                        //$('.resultado').html(response);
                    }
                });
                //alert("Bien!!!, la edad seleccionada es: " + $(this).val());
            });

            function orden_tabla() {
                $('#tabla_registros').DataTable({
                    "order": [
                        [0, "asc"]
                    ],
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
                });
            }
        });
    </script>
@endsection
