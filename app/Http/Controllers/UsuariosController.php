<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Users;
use App\Models\Role;
use App\Models\UsuariosRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('admin', auth()->user())) {
            $datos = Users::all();
            return view('sistema.administracion.admin', compact('datos'));
        } else {
            return redirect('/menu_principal');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Role::all();
        return view('sistema.administracion.add', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $usuario = new Users();
        $roles = new UsuariosRoles();
        $usuario->name = $request->post('nombre');
        $usuario->last_name = $request->post('apellidos');
        $usuario->fecha_nac = $request->post('fnac');
        $usuario->email = $request->post('email');
        $usuario->usuario = $request->post('usuario');
        $usuario->password = encrypt($request->post('password_dos'));
        $usuario->save();
        $roles->user_id = $usuario->id;
        $roles->role_id = $request->post('tipo');
        $roles->save();
        return redirect()->route('admin')->with('success', 'Registro con Exito!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario = Users::find($id);
        $role = Role::all();
        $reg_role = DB::table('usuarios_roles')->where('user_id', $id)->first();
        return view('sistema.administracion.actualizar', compact('usuario', 'role', 'reg_role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idd)
    {
        $usuario = Users::find($idd);
        $roles = UsuariosRoles::find($idd);
        $usuario->name = $request->post('nombre');
        $usuario->last_name = $request->post('apellidos');
        $usuario->fecha_nac = $request->post('fnac');
        $usuario->email = $request->post('email');
        $usuario->usuario = $request->post('usuario');
        $usuario->password = encrypt($request->post('password_uno'));
        $usuario->save();
        //$roles->user_id = $usuario->id;
        $roles->role_id = $request->post('tipo');
        $roles->save();
        return redirect()->route('admin')->with('success', 'Actualizado con Exito!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuario = Users::find($id);
        $usuario->delete();
        return redirect()->route('admin')->with('success', 'Eliminado con Exito!!');
    }
}