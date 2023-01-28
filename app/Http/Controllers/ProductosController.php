<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario_id = auth()->user()->id;
        $user = auth()->user()->usuario;
        $tipo = DB::table('usuarios_roles')->where('user_id', $usuario_id)->first();
        if ($tipo->role_id == 1) { //tipo 1 = admin
            $product = Productos::all();
            return view('sistema.productos.admin', compact('product'));
        } else { // diferente a tipo usuario 1
            $product = Productos::where('usuario', $user)->get(); //obtener datos de ese usuario
            return view('sistema.productos.admin', compact('product'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sistema.productos.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $producto = new Productos();
        $usuario_nombre = auth()->user()->usuario;
        $producto->codigo = $request->post('codigo');
        $producto->nombre_prod = $request->post('producto');
        $producto->nombre_img = $request->post('nombre_imagen');
        $producto->existencia = $request->post('existencia');
        $producto->categoria = $request->post('categoria');
        $producto->descripcion = $request->post('descripcion');
        $producto->marca = $request->post('marca');
        $producto->precio = $request->post('precio');
        $producto->usuario = $usuario_nombre;
        $producto->save();
        $file_name = $request->post('nombre_imagen');
        $path = public_path("img_productos\\" . $usuario_nombre . "\\");
        $files = $_FILES["img"]["tmp_name"];
        //$file = $request->file("img");
        if (!file_exists($path)) {
            if (!is_dir($path)) {
                mkdir($path, 0777, true); //crear la ruta
            }
            copy($files, $path . $file_name);
            return redirect()->route('prod')->with('success', 'Registro con Exito!!');
        } else {
            copy($files, $path . $file_name);

            return redirect()->route('prod')->with('success', 'Registro con Exito!!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function show(Productos $productos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Productos::find($id);
        return view('sistema.productos.actualizar', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $producto = Productos::find($id);
        $usuario_nombre = auth()->user()->usuario;
        $producto->codigo = $request->post('codigo');
        $producto->nombre_prod = $request->post('producto');
        $producto->nombre_img = $request->post('nombre_imagen');
        $producto->existencia = $request->post('existencia');
        $producto->categoria = $request->post('categoria');
        $producto->descripcion = $request->post('descripcion');
        $producto->marca = $request->post('marca');
        $producto->precio = $request->post('precio');
        $producto->save();
        $file_name = $request->post('nombre_imagen');
        $path = public_path("img_productos\\" . $usuario_nombre . "\\");
        $files = $_FILES["img"]["tmp_name"];
        //$file = $request->file("img");
        if (!file_exists($path)) { //no existe la ruta
            if (!is_dir($path)) {
                mkdir($path, 0777, true); //crear la ruta
            }
            copy($files, $path . $file_name);
            return redirect()->route('prod')->with('success', 'Actualizacion con Exito!!');
        } else {
            if (empty($files)) {
                //vacio el archivo
            } else {
                copy($files, $path . $file_name);
            }

            return redirect()->route('prod')->with('success', 'Actualizacion con Exito!!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Productos $productos)
    {
        return "elimina";
    }
    public function getDatos()
    {
        $datos = Productos::all();
        return response()->json($datos);
    }
}