<?php

use App\Http\Controllers\DetalleVentaController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::get('/ventas', [DetalleVentaController::class, 'show_listventas'])->name('ventas.admin');
    Route::get('/ventas/detalle/{id_venta}', [DetalleVentaController::class, 'detalle_venta'])->name('ventas.detalles');
    Route::get('/ventas/detalle/reporte/{id_venta}', [DetalleVentaController::class, 'reporte_pdf'])->name('ventas.reporte');
});