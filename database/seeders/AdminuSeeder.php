<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "a",
            'last_name' => "a",
            'fecha_nac' => "1996-12-05",
            'email' => "pumas89@live.com",
            'usuario' => "Admi",
            'password' => encrypt('Soporte'),
        ]);
        DB::table('usuarios_roles')->insert([
            'user_id' => "1",
            'role_id' => "1",
        ]);
        //ejecutar comando php artisan db:seed --class=AdminuSeeder
    }
}