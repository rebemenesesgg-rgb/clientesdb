<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MikroTikService
{
    private function conexion()
    {
        return Http::withBasicAuth(
            env('MIKROTIK_USER'),
            env('MIKROTIK_PASSWORD')
        )
        ->acceptJson()
        ->timeout(5);
    }

    public function obtenerClientes()
    {
        return $this->conexion()->get(
            'http://' . env('MIKROTIK_HOST') . '/rest/ppp/secret'
        );
    }

    public function obtenerActivos()
    {
        return $this->conexion()->get(
            'http://' . env('MIKROTIK_HOST') . '/rest/ppp/active'
        );
    }

    public function crearClientePPPoE($datos)
    {
        return $this->conexion()->put(
            'http://' . env('MIKROTIK_HOST') . '/rest/ppp/secret',
            [
                'name' => $datos['nombre'],
                'password' => $datos['clave'],
                'service' => 'pppoe',
                'profile' => $datos['perfil'],
                'comment' => $datos['comentario'] ?? '',
            ]
        );
    }
}
