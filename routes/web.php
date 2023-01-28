<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class, 'index'])->name('login.index');
Route::get('/inicio', [LoginController::class, 'index'])->name('login.index');
Route::post('/', [LoginController::class, 'show'])->name('login.show'); //buscar accesos
Route::post('/logout', [LoginController::class, 'exit'])->name('login.exit'); //ya logueado
Route::get('/menu_principal', function () {
    return view('sistema.index');
})->middleware('auth')->name('menu_principal'); //cuando ya inicio sesion
Route::get('/inicio', function () {
    return view('inicio');
})->middleware('guest')->name('inicio'); //cuando no ha iniciado sesion
Route::get('/administracion', [UsuariosController::class, 'index'], function () {
    return view('sistema.administracion.admin');
})->middleware('auth')->name('admin');
Route::get('/administracion/create', [UsuariosController::class, 'create'])->middleware('auth')->name('admin.add');
Route::post('/administracion/store', [UsuariosController::class, 'store'])->name('usuario.add');
Route::get('/administracion/edit/{id}', [UsuariosController::class, 'edit'])->middleware('auth')->name('usuario.edit');
Route::put('/administracion/update/{id}', [UsuariosController::class, 'update'])->name('usuario.update');
Route::get('personas/destroy/{id}', [UsuariosController::class, 'destroy'])->middleware('auth')->name('usuario.delete');