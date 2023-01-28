<?php

use App\Http\Controllers\DetalleVentaController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::get('/tienda', [DetalleVentaController::class, 'index'])->name('tienda.admin');
    Route::post('/tienda/producto', [DetalleVentaController::class, 'store'])->name('tienda.add');
    Route::get('/tienda/carrito', [DetalleVentaController::class, 'show'])->name('tienda.carrito');
    route::get('/tienda/carrito/{id}', [DetalleVentaController::class, 'destroy'])->name('tienda.delete');
    route::get('/tienda/producto/{cantidad}', [DetalleVentaController::class, 'edit'])->name('tienda.update');
    route::get('/tienda/pago', [DetalleVentaController::class, 'pago'])->name('tienda.paypal');
    Route::get('/tienda/pago/cancelacion', [DetalleVentaController::class, 'cancelacion'])->name('tienda.cancelacion');
    Route::get('/tienda/pago/proceso/{OrderID}', [DetalleVentaController::class, 'proceso_pago'])->name('tienda.proceso_pago');
});