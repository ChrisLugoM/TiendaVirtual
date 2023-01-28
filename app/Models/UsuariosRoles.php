<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuariosRoles extends Model
{
    public function getKeyName()
    {
        return 'user_id';
        //cambiar el 'id' por el nombre original de esa tabla
    }
    public $timestamps = false;
    use HasFactory;
}