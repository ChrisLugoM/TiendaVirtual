@extends('plantillas/menu')
@section('title_pagina', 'Tienda')
@section('enlaces')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tienda.css') }}">
@endsection
@section('contenido')
    <div class="card" style="">
        <div class="card-body">
            <div class="">
                <h2 class="card-title text-center text-success"><b>Carrito de Compras</b></h2><br>
                <div class="row card-body">
                    <div class="col-6" style="float: left"><a href="{{ route('tienda.admin') }}"
                            class="btn btn-dark"><i class="fas fa-undo-alt">Regresar</i></a></div>
                    <div class="col-6"><a style="float: right;" href="{{ route('tienda.paypal') }}"
                            class="btn btn-success"><i class="fa fa-credit-card">Pagar</i></a></div>
                </div>
                <table class="table table-sm table-bordered" id="tabla_registros" style="width: 100%;" border="5">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Producto</th>
                            <th>Precio Unitario</th>
                            <th>Cantidad</th>
                            <th>Precio Total</th>
                            <th>Quitar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (Cart::getContent() as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td class="text-center" width="100px">
                                    <input type="hidden" name="id_prod" value="{{ $row->id }}">
                                    <img src="{{ asset('img_productos/' . $row->user . '/' . $row->img) }}" width="100%">
                                </td>
                                <td>${{ number_format($row->price, 2) }}</td>
                                <td><select name="cant" id="cant" data-content="{{ $row->id }}">
                                        @php
                                            $count = $row->existencia;
                                        @endphp
                                        @for ($i = 1; $i <= $count; $i++)
                                            <option <?php if($i == $row->quantity){ ?> value="{{ $row->quantity }}" selected
                                                <?php }?>>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                    <!--<input type="number" data-content="$row->id }}" name="cant" id="cant" value="" min="1" max="10">-->
                                </td>
                                <td>${{ number_format($row->price * $row->quantity, 2) }}</td>
                                <td>
                                    <form action="{{ route('tienda.delete', $row->id) }}" method="GET"><button
                                            class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button></form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"></td>
                            <td>SubTotal</td>
                            <td>${{ number_format(Cart::getSubtotal(), 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td>IVA 16%</td>
                            @php
                                $total_iva = number_format(Cart::getSubtotal() * 0.16, 2);
                            @endphp
                            <td>${{ number_format($total_iva, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td>Total a Pagar</td>
                            @php
                                $total = number_format($total_iva + Cart::getTotal(), 2);
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
