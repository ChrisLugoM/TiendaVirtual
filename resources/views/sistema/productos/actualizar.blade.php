@extends('plantillas/menu')
@section('title_pagina', 'Agregar Producto')
@section('enlaces')
    <link rel="stylesheet" href="{{ asset('css/form_admin.css') }}">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
@section('contenido')
    <div class="card">
        <div class="card-header">
            <h3 style="color: slateblue;font-weight: bold;text-align: center">Agregar registro de Producto</h3>
        </div>
        <div class="card-body">
            <div class="container">
                <form action="{{ route('product.update', $product->id) }}" method="POST" autocomplete="off"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="p-1 bg-light">
                        <div class="row">
                            <div class="col-3">
                                <label for="" class="control-label col-md-4">Producto</label>
                                <img src="{{ asset('img_productos/' . $product->usuario . '/' . $product->nombre_img) }}"
                                    id="image_producto" style="width: 95%;height: 120px" class="form-control">
                            </div>
                            <div class="col-9"><br>
                                <label class="fw-bold">Cargar Imagen:</label>
                                <input type="file" accept="image/*" class="form-control" name="img" id="img"
                                    onchange="img_producto()" onblur="nombre_file()">
                                <input type="hidden" id="nombre_imagen" name="nombre_imagen">
                            </div>
                        </div>
                    </div>
                    <div class="p-1 bg-light">
                        <label class="fw-bold">Codigo de Producto:</label>
                        <input type="text" class="form-control" name="codigo" placeholder="Codigo de producto"
                            value="{{ $product->codigo }}" required>
                    </div>
                    <div class="p-1 bg-light">
                        <label class="fw-bold">Nombre del Producto:</label>
                        <input type="text" class="form-control" name="producto" placeholder="Nombre"
                            value="{{ $product->nombre_prod }}" required onblur="nombre_img()">
                    </div>
                    <div class="p-1 bg-light">
                        <label class="fw-bold">Existencia de Producto:</label>
                        <input type="number" class="form-control" name="existencia" maxlength="3" placeholder="📦"
                            value="{{ $product->existencia }}" required pattern="[0-9]"
                            onkeypress="return numeros(event)">
                    </div>
                    <div class="p-1 bg-light">
                        <label class="fw-bold">Marca:</label>
                        <input type="text" class="form-control" name="marca" maxlength="25" placeholder="Marca"
                            value="{{ $product->marca }}">
                    </div>
                    <div class="p-1 bg-light">
                        <label class="fw-bold">Categoria:</label>
                        <input type="text" class="form-control" name="categoria" placeholder="Categoria"
                            value="{{ $product->categoria }}">
                    </div>
                    <div class="p-1 bg-light">
                        <label class="fw-bold">Precio:</label>
                        <input type="number" class="form-control" name="precio" min="0.00" max="10000.00" step="any"
                            placeholder="$$$" value="{{ $product->precio }}" onkeypress="return numeros(event)">
                    </div>
                    <div class="p-1 bg-light">
                        <div class="row">
                            <div class="col-sm-2">
                                <label class="fw-bold">Descripcion:</label>
                            </div>
                            <div class="col-sm-10">
                                <textarea name="descripcion" cols="60" rows="3"
                                    placeholder="Escribe la descripcion del producto aqui....">{{ $product->descripcion }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="p-2 bg-light">
                        <a href="{{ route('prod') }}" class="btn btn-dark"><i class="fas fa-undo-alt">Regresar</i></a>
                        <button type="submit" id="btn_guardar" class="btn btn-primary"><i
                                class="fas fa-user-plus">Guardar</i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/validacion.js') }}"></script>
@endsection
