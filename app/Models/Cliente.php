<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
    'nombre',
    'correo',
    'telefono',
    'direccion',
    'may',
    'jun',
    'jul',
    'agos',
    'sep',
    'oct',
    'nov',
    'dic',
    'notas'
];
}