<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('productos', function ($user) {
            /* Acceso a productos
            1 = admin
            2 = ventas
            */
            $role = DB::table('usuarios_roles')->where('user_id', $user->id)->first();
            if ($role->role_id == 1 || $role->role_id == 2) {
                return true;
            } else {
                return false;
            }
        });
        Gate::define('admin', function ($user) {
            /* Acceso a administracion
            1 = admin
            2 = ventas
            */
            $role = DB::table('usuarios_roles')->where('user_id', $user->id)->first();
            if ($role->role_id == 1) {
                return true;
            }
            return false;
        });
    }
}