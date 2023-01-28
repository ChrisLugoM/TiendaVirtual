<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    protected $table = "users"; //tabla a consultar
    protected $fillable = ['id', 'name', 'email', 'created_at'];
}