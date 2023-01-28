<?php

use App\Http\Controllers\RoleController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::get('/roles', [RoleController::class, 'index'])->name('rol_admin');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('rol_admin.add');
    Route::post('/roles/store', [RoleController::class, 'store'])->name('rol_admin.save');
    Route::get('/roles/edit/{id}', [RoleController::class, 'edit'])->name('rol_admin.edit');
    Route::put('/roles/update/{id}', [RoleController::class, 'update'])->name('rol_admin.update');
    Route::get('/roles/destroy/{id}', [RoleController::class, 'destroy'])->name('rol_admin.delete');
});