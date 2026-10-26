<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudCorte extends Model
{
    protected $table = 'solicitudes_corte';

    protected $fillable = [
        'cliente',
        'estado',
        'fecha_solicitud',
    ];
}