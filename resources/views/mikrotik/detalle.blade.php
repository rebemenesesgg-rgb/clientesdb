<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detalle del cliente</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 40px;
        }

        .contenedor {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        h1 {
            margin-top: 0;
        }

        h2 {
            margin-top: 30px;
        }

        .dato {
            padding: 15px 0;
            border-bottom: 1px solid #ddd;
        }

        .dato strong {
            display: inline-block;
            width: 180px;
        }

        .conectado {
            color: green;
            font-weight: bold;
        }

        .desconectado {
            color: #777;
            font-weight: bold;
        }

        .volver {
            display: inline-block;
            margin-top: 25px;
            padding: 10px 16px;
            background: #222;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .volver:hover {
            opacity: 0.8;
        }

        .boton-cortar {
            margin-top: 25px;
            margin-left: 10px;
            padding: 10px 16px;
            background: #c62828;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .boton-cortar:hover {
            opacity: 0.8;
        }

        .mensaje {
            margin-bottom: 20px;
            padding: 12px;
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <div class="contenedor">

        <h1>Detalle del cliente</h1>

        {{-- Mensaje después de realizar la acción --}}
        @if (session('mensaje'))
            <div class="mensaje">
                {{ session('mensaje') }}
            </div>
        @endif

        <h2>Información de la cuenta</h2>

        <div class="dato">
            <strong>Nombre:</strong>
            {{ $cliente['name'] ?? 'No disponible' }}
        </div>

        <div class="dato">
            <strong>Servicio:</strong>
            {{ $cliente['service'] ?? 'No disponible' }}
        </div>

        <div class="dato">
            <strong>Perfil:</strong>
            {{ $cliente['profile'] ?? 'No disponible' }}
        </div>

        <div class="dato">
            <strong>Estado de cuenta:</strong>

            @if (($cliente['disabled'] ?? 'false') === 'true')
                <span class="desconectado">
                    Deshabilitado
                </span>
            @else
                <span class="conectado">
                    Activo
                </span>
            @endif
        </div>

        <h2>Sesión actual</h2>

        @if ($sesion)

            <div class="dato">
                <strong>Conexión:</strong>

                <span class="conectado">
                    Conectado
                </span>
            </div>

            <div class="dato">
                <strong>Dirección IP:</strong>
                {{ $sesion['address'] ?? 'No disponible' }}
            </div>

            <div class="dato">
                <strong>Tiempo conectado:</strong>
                {{ $sesion['uptime'] ?? 'No disponible' }}
            </div>

            <div class="dato">
                <strong>Servicio:</strong>
                {{ $sesion['service'] ?? 'No disponible' }}
            </div>

        @else

            <div class="dato">
                <strong>Conexión:</strong>

                <span class="desconectado">
                    Desconectado
                </span>
            </div>

        @endif


        {{-- Botón para regresar --}}
        <a href="{{ url('/mikrotik/probar') }}" class="volver">
            Volver a clientes
        </a>


        {{-- Formulario de prueba para cortar servicio --}}
        <form
            action="{{ url('/mikrotik/cliente/' . urlencode($cliente['name']) . '/cortar') }}"
            method="POST"
            style="display: inline;">

            @csrf

            <button
                type="submit"
                class="boton-cortar">

                Cortar servicio

            </button>

        </form>

    </div>

</body>
</html>