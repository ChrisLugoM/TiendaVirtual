<?php

use App\Http\Controllers\ProductosController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::get('/productos', [ProductosController::class, 'index'], function () {
        return view('sistema.productos.admin');
    })->name('prod');
    Route::get('/productos/create', [ProductosController::class, 'create'])->name('product.add');
    Route::post('/productos/store', [ProductosController::class, 'store'])->name('product.save');
    Route::get('/productos/edit/{id}', [ProductosController::class, 'edit'])->name('product.edit');
    Route::put('/productos/update/{id}', [ProductosController::class, 'update'])->name('product.update');
    Route::get('/productos/destroy/{id}', [ProductosController::class, 'destroy'])->name('product.delete');
    Route::get('/productos/datos', [ProductosController::class, 'getDatos'])->name('product.api');
});