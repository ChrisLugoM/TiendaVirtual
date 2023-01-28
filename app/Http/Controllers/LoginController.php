<?php

namespace App\Http\Controllers;

use App\Models\User;
use Faker\Provider\UserAgent;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('inicio');
    }

    public function menu()
    {
        return view('sistema.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //

        $password = $request->input('password');
        $email = $request->input('usuario');
        $user = User::where('usuario', $email)->first();

        if ($password === decrypt($user->password)) {
            Auth::login($user); //for user auth session
            request()->session()->regenerate();
            return redirect('menu_principal');
        } else {
            return redirect('inicio');
        }
        //$query = User::where('usuario', '=', $email)->get(); //bd colum usuario

        /*$cred = request()->only('usuario', 'password'); //bd colum usuario
        if (Auth::attempt($cred)) {
            request()->session()->regenerate();
            return redirect('menu_principal');
        } else {
            //Route::view('/', 'inicio')->middleware('guest');
            return redirect('inicio');
        }
        //password_verify($password, $pws)
        //return view('sistema/index', compact('products'));
*/
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function exit(Request $req)
    {
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        return redirect('/inicio');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}