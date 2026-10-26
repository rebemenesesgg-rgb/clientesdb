<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\SolicitudCorte;
use App\Services\MikroTikService;

class MikroTikController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CONEXIÓN Y CLIENTES PPPoE
    |--------------------------------------------------------------------------
    */

    public function probar(MikroTikService $mikrotik)
    {
        $respuesta = $mikrotik->obtenerClientes();

        $respuestaActivos = Http::withBasicAuth(
            env('MIKROTIK_USER'),
            env('MIKROTIK_PASSWORD')
        )->timeout(5)->get(
            'http://' . env('MIKROTIK_HOST') . '/rest/ppp/active'
        );

        $usuarios = $respuesta->json() ?? [];
        $activos = $respuestaActivos->json() ?? [];

        $nombresActivos = collect($activos)
            ->pluck('name')
            ->toArray();

        $clientes = collect($usuarios)->map(function ($usuario) use ($nombresActivos) {
            $nombre = $usuario['name'] ?? null;

            return [
                'nombre' => $nombre,
                'servicio' => $usuario['service'] ?? null,
                'perfil' => $usuario['profile'] ?? null,
                'deshabilitado' => $usuario['disabled'] ?? false,
                'conectado' => in_array($nombre, $nombresActivos),
            ];
        });

        return view('mikrotik.clientes', [
            'clientes' => $clientes,
            'totalClientes' => $clientes->count(),
            'totalConectados' => $clientes->where('conectado', true)->count(),
        ]);
    }

    public function detalle(MikroTikService $mikrotik, $nombre)
    {
        $respuesta = $mikrotik->obtenerClientes();
        $usuarios = $respuesta->json() ?? [];

        $cliente = collect($usuarios)->first(function ($usuario) use ($nombre) {
            return ($usuario['name'] ?? '') === $nombre;
        });

        if (!$cliente) {
            abort(404, 'Cliente no encontrado');
        }

        $respuestaActivos = $mikrotik->obtenerActivos();
        $activos = $respuestaActivos->json() ?? [];

        $sesion = collect($activos)->first(function ($activo) use ($nombre) {
            return ($activo['name'] ?? '') === $nombre;
        });

        return view('mikrotik.detalle', [
            'cliente' => $cliente,
            'sesion' => $sesion,
        ]);
    }

    public function cortar($nombre)
    {
        SolicitudCorte::create([
            'cliente' => $nombre,
            'estado' => 'solicitado',
        ]);

        return redirect('/mikrotik/cliente/' . urlencode($nombre))
            ->with(
                'mensaje',
                'Solicitud de corte registrada. Todavía no se realizó ningún cambio en MikroTik.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | CLIENTES WIFI Y ANCHO DE BANDA
    |--------------------------------------------------------------------------
    */

    public function clientesWifi()
    {
        try {
            $respuesta = Http::withBasicAuth(
                env('MIKROTIK_USER'),
                env('MIKROTIK_PASSWORD')
            )->timeout(3)->get(
                'http://' . env('MIKROTIK_HOST') . '/rest/queue/simple'
            );

            $queues = $respuesta->successful()
                ? ($respuesta->json() ?? [])
                : [];
        } catch (\Throwable $e) {
            $queues = [];
        }

        return view('clienteswifi', [
            'queues' => $queues,
        ]);
    }

    public function cambiarAncho(Request $request)
    {
        $datos = $request->validate([
            'id' => 'required',
            'upload' => 'required|numeric|min:0',
            'download' => 'required|numeric|min:0',
        ]);

        $upload = $datos['upload'] * 1000000;
        $download = $datos['download'] * 1000000;
        $limite = $upload . '/' . $download;

        $respuesta = Http::withBasicAuth(
            env('MIKROTIK_USER'),
            env('MIKROTIK_PASSWORD')
        )->timeout(5)->patch(
            'http://' . env('MIKROTIK_HOST') . '/rest/queue/simple/' . $datos['id'],
            [
                'max-limit' => $limite,
            ]
        );

        if (!$respuesta->successful()) {
            return back()->with(
                'mensaje',
                'No se pudo actualizar el ancho de banda en MikroTik.'
            );
        }

        return redirect('/mikrotik/clientes-wifi')
            ->with('mensaje', 'Ancho de banda actualizado correctamente.');
    }

    /*
    |--------------------------------------------------------------------------
    | LISTAR Y CREAR CLIENTES PPPoE
    |--------------------------------------------------------------------------
    */

    public function listarPPoe(MikroTikService $mikrotik)
    {
        try {
            $respuesta = $mikrotik->obtenerClientes();

            $clientes = $respuesta->successful()
                ? ($respuesta->json() ?? [])
                : [];
        } catch (\Throwable $e) {
            $clientes = [];
        }

        return view('mikrotik.listarPPoe', [
            'clientes' => $clientes,
            'errorConexion' => empty($clientes),
        ]);
    }

    public function mostrarCrearPPoe()
    {
        return view('mikrotik.crearPPoe');
    }

    public function crearPPoe(Request $request, MikroTikService $mikrotik)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:100',
            'clave' => 'required|string|max:100',
            'perfil' => 'required|string|max:100',
            'comentario' => 'nullable|string|max:200',
        ]);

        $respuesta = $mikrotik->crearClientePPPoE($datos);

        if ($respuesta->successful()) {
            return redirect('/mikrotik/listarPPoe')
                ->with('mensaje', 'Cliente PPPoE creado correctamente en MikroTik.');
        }

        return back()
            ->withInput()
            ->with(
                'mensaje',
                'No se pudo crear el cliente en MikroTik: ' . $respuesta->body()
            );
    }

    /*
    |--------------------------------------------------------------------------
    | VISTA WIFI
    |--------------------------------------------------------------------------
    */

    public function wifi()
    {
        try {
            $respuesta = Http::withBasicAuth(
                env('MIKROTIK_USER'),
                env('MIKROTIK_PASSWORD')
            )->timeout(3)->get(
                'http://' . env('MIKROTIK_HOST', '10.0.0.1')
                . '/rest/ip/firewall/filter'
            );

            $reglas = $respuesta->successful()
                ? ($respuesta->json() ?? [])
                : [];

            $clientes = collect($reglas)
                ->filter(function ($regla) {
                    $comentario = $regla['comment'] ?? '';

                    return str_starts_with($comentario, 'CORTE_IP_')
                        || $comentario === 'BLOQUEO_WIFI_GENERAL';
                })
                ->map(function ($regla) {
                    $comentario = $regla['comment'] ?? '';

                    return [
                        'id' => $regla['.id'] ?? $regla['id'] ?? null,
                        'ip' => str_replace('CORTE_IP_', '', $comentario),
                        'disabled' => filter_var(
                            $regla['disabled'] ?? false,
                            FILTER_VALIDATE_BOOLEAN
                        ),
                    ];
                })
                ->values()
                ->all();

            return view('mikrotik.wifi', [
                'clientes' => $clientes,
                'error' => $respuesta->successful()
                    ? null
                    : 'No se pudo consultar MikroTik. Se muestra la vista sin datos.',
            ]);
        } catch (\Throwable $e) {
            return view('mikrotik.wifi', [
                'clientes' => [],
                'error' => 'MikroTik no está disponible. Se muestra la vista sin datos.',
            ]);
        }
    }

    public function agregarIp(Request $request)
{
    $request->validate([
        'ip' => 'required|ip',
    ]);

    try {
        $ip = $request->ip;

        $respuesta = Http::withBasicAuth(
            env('MIKROTIK_USER'),
            env('MIKROTIK_PASSWORD')
        )->timeout(3)->post(
            'http://' . env('MIKROTIK_HOST', '10.0.0.1')
            . '/rest/ip/firewall/filter',
            [
                'chain' => 'forward',
                'src-address' => $ip,
                'action' => 'drop',
                'comment' => 'CORTE_IP_' . $ip,
                'disabled' => 'false',
            ]
        );

        if ($respuesta->successful()) {
            return back()->with(
                'mensaje',
                'IP agregada correctamente al control de Internet.'
            );
        }

        return back()->with(
            'mensaje',
            'No se pudo agregar la IP: ' . $respuesta->body()
        );

    } catch (\Throwable $e) {
        return back()->with(
            'mensaje',
            'Error al conectar con MikroTik: ' . $e->getMessage()
        );
    }
}

    /*
    |--------------------------------------------------------------------------
    | VISTA MOROSOS
    |--------------------------------------------------------------------------
    */

    public function morosos()
{
    try {
        $respuesta = Http::withBasicAuth(
            env('MIKROTIK_USER'),
            env('MIKROTIK_PASSWORD')
        )
        ->acceptJson()
        ->timeout(5)
        ->get(
            'http://' . env('MIKROTIK_HOST', '10.0.0.1')
            . '/rest/ip/firewall/address-list'
        );

        if (!$respuesta->successful()) {
            return view('mikrotik.morosos', [
                'morosos' => [],
                'error' => 'No se pudo consultar MikroTik: '
                    . $respuesta->body(),
            ]);
        }

        $registros = $respuesta->json();

        if (!is_array($registros)) {
            $registros = [];
        }

        $morosos = collect($registros)
            ->filter(function ($registro) {
                return is_array($registro)
                    && ($registro['list'] ?? '') === 'MOROSOS'
                    && !empty($registro['.id']);
            })
            ->values()
            ->all();

        return view('mikrotik.morosos', [
            'morosos' => $morosos,
            'error' => null,
        ]);

    } catch (\Throwable $e) {
        return view('mikrotik.morosos', [
            'morosos' => [],
            'error' => 'Error al conectar con MikroTik: '
                . $e->getMessage(),
        ]);
    }
}

    public function agregarMoroso(Request $request)
{
    $request->validate([
        'ip' => 'required|ip',
    ]);

    try {
        $respuesta = Http::withBasicAuth(
            env('MIKROTIK_USER'),
            env('MIKROTIK_PASSWORD')
        )->acceptJson()->timeout(5)->post(
            'http://' . env('MIKROTIK_HOST', '10.0.0.1')
            . '/rest/ip/firewall/address-list/add',
            [
                'list' => 'MOROSOS',
                'address' => $request->input('ip'),
                'comment' => 'MOROSO',
            ]
        );

        if ($respuesta->successful()) {
            return back()->with(
                'mensaje',
                'Moroso agregado correctamente.'
            );
        }

        return back()->with(
            'mensaje',
            'Error de MikroTik: ' . $respuesta->body()
        );

    } catch (\Throwable $e) {
        return back()->with(
            'mensaje',
            'Error de conexión con MikroTik: ' . $e->getMessage()
        );
    }
}


public function habilitarMoroso($id)
{
    try {
        // Validar el identificador de MikroTik, por ejemplo *1.
        if (!preg_match('/^\*[0-9A-Fa-f]+$/', $id)) {
            return back()->with(
                'mensaje',
                'Error: el identificador de MikroTik no es válido.'
            );
        }

        // Mantener el asterisco del identificador sin codificarlo.
        $url = 'http://' . env('MIKROTIK_HOST', '10.0.0.1')
            . '/rest/ip/firewall/address-list/' . $id;

        $respuesta = Http::withBasicAuth(
            env('MIKROTIK_USER'),
            env('MIKROTIK_PASSWORD')
        )
        ->acceptJson()
        ->timeout(5)
        ->patch($url, [
            'disabled' => 'false',
        ]);

        if ($respuesta->successful()) {
            return back()->with(
                'mensaje',
                'Moroso habilitado correctamente.'
            );
        }

        return back()->with(
            'mensaje',
            'No se pudo habilitar el moroso: ' . $respuesta->body()
        );

    } catch (\Throwable $e) {
        return back()->with(
            'mensaje',
            'Error al conectar con MikroTik: ' . $e->getMessage()
        );
    }
}


public function deshabilitarMoroso($id)
{
    try {
        // Validar el identificador recibido de MikroTik, por ejemplo *1.
        if (!preg_match('/^\*[0-9A-Fa-f]+$/', $id)) {
            return back()->with(
                'mensaje',
                'Error: el identificador de MikroTik no es válido.'
            );
        }

        $url = 'http://' . env('MIKROTIK_HOST', '10.0.0.1')
            . '/rest/ip/firewall/address-list/' . $id;

        $respuesta = Http::withBasicAuth(
            env('MIKROTIK_USER'),
            env('MIKROTIK_PASSWORD')
        )
        ->acceptJson()
        ->timeout(5)
        ->patch($url, [
            'disabled' => 'true',
        ]);

        if ($respuesta->successful()) {
            return back()->with(
                'mensaje',
                'Servicio cortado correctamente.'
            );
        }

        return back()->with(
            'mensaje',
            'No se pudo cortar el servicio: ' . $respuesta->body()
        );

    } catch (\Throwable $e) {
        return back()->with(
            'mensaje',
            'Error al conectar con MikroTik: ' . $e->getMessage()
        );
    }
}

public function eliminarMoroso($id)
{
    try {
        $respuesta = Http::withBasicAuth(
            env('MIKROTIK_USER'),
            env('MIKROTIK_PASSWORD')
        )->timeout(3)->delete(
            'http://' . env('MIKROTIK_HOST', '10.0.0.1')
            . '/rest/ip/firewall/address-list/' . rawurlencode($id)
        );

        if ($respuesta->successful()) {
            return back()->with(
                'mensaje',
                'Moroso eliminado correctamente.'
            );
        }

        return back()->with(
            'mensaje',
            'No se pudo eliminar el moroso: ' . $respuesta->body()
        );

    } catch (\Throwable $e) {
        return back()->with(
            'mensaje',
            'Error al conectar con MikroTik: ' . $e->getMessage()
        );
    }
}
}
