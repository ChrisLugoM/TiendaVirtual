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
            <h2 class="card-title text-center text-success"><b>Productos en Venta</b></h2>
            <div>
                @if (count(Cart::getContent()))
                    <a class="btn btn-primary" href="{{ route('tienda.carrito') }}"><i
                            class="fa fa-shopping-bag">Carrito({{ count(Cart::getContent()) }})</i></a>
                @else
                    <a class="btn btn-primary" href="{{ route('tienda.carrito') }}"><i
                            class="fa fa-shopping-bag">Carrito({{ count(Cart::getContent()) }})</i></a>
                @endif
            </div>
            <div class="row">
                <?php $i = 0; ?>
                @while ($i < $total)
                    @foreach ($productos as $item)
                        <div class="col-3" id="cuadro_producto">
                            <form action="{{ route('tienda.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->id }}">
                                <div class="cuadro_norte">
                                    <img src="{{ asset('img_productos/' . $item->usuario . '/' . $item->nombre_img) }}"
                                        class="card-img-top img-fluid" title="{{ $item->nombre_prod }}"
                                        data-bs-trigger="hover" data-bs-content="{{ $item->descripcion }}">
                                </div>
                                <div class="cuadro_sur card-body">
                                    <h5 class="card-title text-danger"><b>{{ $item->nombre_prod }}</b></h5>
                                    <p class="card-text text-dark"><b>Marca: {{ $item->marca }}</b></p>
                                    <label>Cantidad</label>
                                    <input type="number" name="cantidad" id="cantidad" max="10" value="1">
                                    <button class="btn btn-success" type="submit"><i class="fas fa-cart-plus fa-sm">Costo:
                                            {{ $item->precio }}</i></button>
                                </div>
                        </div>
                        <?php $i++;
                        if ($i % 4 == 0) {
                            echo '<hr style="height:10px;margin-top:15px;background-color:black;">';
                        }
                        ?>
                        </form>
                    @endforeach
                @endwhile
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
        });
    </script>
@endsection
