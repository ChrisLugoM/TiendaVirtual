@extends('plantillas/menu')
@section('title_pagina', 'Pago')
@section('enlaces')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tienda.css') }}">
    <script
        src="https://www.paypal.com/sdk/js?client-id=ASt2HeonrX_aJNd74pH-MKxWMiZXr-lBtIkZpQyGxPqB9-I7QHPs0fj4Xei4A8t0xGQgagbjhVLEywMf&currency=MXN">
    </script>
@endsection
@section('contenido')<br>
    <div class="col-6">
        <a href="{{ route('tienda.carrito') }}" class="btn btn-dark"><i class="fas fa-undo-alt">Regresar</i></a>
    </div>
    <div class="card" style="">
        <div class="card-body">
            <div class="">
                <h2 class="card-title text-center text-success"><b>Metodos de Pago</b></h2><br>
                <div class="row card-body text-center">
                    <div id="paypal-button-container"></div>
                </div>
                <div class="resultado">
                </div>
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
    <script
        src="https://www.paypal.com/sdk/js?client-id=AQAgUcO4tuMp_riAhXNn3-p86jBIcrEMLNILkBnT56IBPBZDL5kd_c5Z8Ej8jdphr4IBgPMAehnPG0Cw&currency=MXN">
    </script>
    <script type="text/javascript">
        var total_pago = "<?php echo $total; ?>";
        paypal.Buttons({
            style: {
                color: 'blue',
                label: 'pay'
            },
            createOrder: (data, actions) => {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: total_pago // Colocar el costo de la venta
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                actions.order.capture().then(function(Orden) {
                    var order = data.orderID;
                    var parametros = {
                        "OrderID": order
                    };
                    $.ajax({
                        type: "get",
                        url: "/tienda/pago/proceso/{OrderID}",
                        data: parametros,
                        success: function(response) {
                            $('.resultado').html(response);
                            if (response == "COMPLETED") {
                                alert("PAGO COMPLETADO");
                                window.location.href = "{{ route('tienda.admin') }}";
                            } else {
                                alert("NO SE COMPLETO EL PAGO SE LE REGRESARA SU DINERO");
                                window.location.href = "{{ route('tienda.admin') }}";
                            }
                            console.log(response);
                            //console.log("hola mundo");
                        }
                    });
                    //alert("Transaccion completada: " + data.orderID);
                });
            },
            onCancel: function(data) {
                console.log(data);
                var order = data.orderID;
                var parametros = {
                    "orden": order,
                    "total": total_pago
                };
                $.ajax({
                    type: "get",
                    url: "/tienda/pago/cancelacion",
                    data: parametros,
                    success: function(response) {
                        alert("Pago Cancelado");
                        //window.location.href = "{{ route('tienda.admin') }}";
                    }
                });
            }
        }).render('#paypal-button-container');
    </script>
@endsection
