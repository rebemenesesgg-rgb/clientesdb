
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Morosos</title>

    <style>
        :root {
            --verde: #65B32E;
            --verde-hover: #4F8F24;
            --verde-oscuro: #203B12;
            --negro: #000000;
            --fondo: #101010;
            --gris: #C6C6C6;
            --blanco: #FFFFFF;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: var(--negro);
            color: var(--blanco);
        }

        .contenedor {
            max-width: 1000px;
            margin: auto;
        }

        .tarjeta {
            background: var(--fondo);
            padding: 25px;
            border-radius: 12px;
            border: 2px solid var(--verde);
            box-shadow: 0 0 15px rgba(101,179,46,.20);
        }

        h1 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 25px;
            color: var(--verde);
        }

        h1::after {
            content: "";
            display: block;
            width: 100px;
            height: 4px;
            background: var(--verde);
            margin: 10px auto 0;
            border-radius: 5px;
        }

        .formulario {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
        }

        .formulario input {
            flex: 1;
            min-width: 0;
            padding: 12px;
            border: 2px solid var(--verde);
            border-radius: 6px;
            font-size: 16px;
            background: var(--negro);
            color: var(--blanco);
            outline: none;
        }

        .formulario input::placeholder {
            color: var(--gris);
        }

        .formulario input:focus {
            box-shadow: 0 0 8px rgba(101,179,46,.35);
        }

        button {
            border-radius: 6px;
            padding: 9px 14px;
            font-weight: bold;
            cursor: pointer;
            transition: .2s;
        }

        .btn-agregar {
            background: var(--verde);
            color: var(--negro);
            border: 2px solid var(--verde);
            padding: 12px 20px;
        }

        .btn-agregar:hover,
        .btn-habilitar:hover {
            background: var(--verde-hover);
            color: var(--blanco);
        }

        .tabla-contenedor {
            width: 100%;
            overflow-x: auto;
            border: 2px solid var(--verde);
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        th {
            background: var(--verde);
            color: var(--negro);
            padding: 14px;
            text-align: center;
            border-right: 1px solid var(--verde-oscuro);
        }

        td {
            padding: 14px;
            border-bottom: 1px solid var(--verde-oscuro);
            border-right: 1px solid var(--verde-oscuro);
            text-align: center;
            background: var(--negro);
            color: var(--blanco);
        }

        tbody tr:nth-child(even) td {
            background: #101A0B;
        }

        tbody tr:hover td {
            background: var(--verde-oscuro);
        }

        .ip {
            font-weight: bold;
            font-size: 17px;
            color: var(--verde);
        }

        .estado-habilitado {
            color: var(--verde);
            font-weight: bold;
        }

        .estado-cortado {
            color: var(--gris);
            font-weight: bold;
        }

        .acciones {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 7px;
            flex-wrap: wrap;
        }

        .acciones form {
            margin: 0;
        }

        .btn-habilitar {
            background: var(--verde);
            color: var(--negro);
            border: 2px solid var(--verde);
        }

        .btn-cortar {
            background: var(--negro);
            color: var(--verde);
            border: 2px solid var(--verde);
        }

        .btn-cortar:hover {
            background: var(--verde);
            color: var(--negro);
        }

        .btn-eliminar {
            background: var(--negro);
            color: var(--gris);
            border: 2px solid var(--gris);
        }

        .btn-eliminar:hover {
            background: var(--gris);
            color: var(--negro);
        }

        .btn-volver {
            display: inline-block;
            margin-top: 20px;
            background: var(--verde);
            color: var(--negro);
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 7px;
            border: 2px solid var(--verde);
            font-weight: bold;
        }

        .btn-volver:hover {
            background: var(--verde-hover);
            color: var(--blanco);
        }

        .mensaje {
            padding: 13px;
            border-radius: 7px;
            margin-bottom: 20px;
            font-weight: bold;
            overflow-wrap: anywhere;
        }

        .success {
            background: var(--verde-oscuro);
            color: var(--verde);
            border: 1px solid var(--verde);
        }

        .error {
            background: #202020;
            color: var(--gris);
            border: 1px solid var(--gris);
        }

        @media (max-width: 600px) {
            body {
                padding: 8px;
            }

            .contenedor {
                width: 100%;
            }

            .tarjeta {
                padding: 12px;
                border-radius: 8px;
            }

            h1 {
                font-size: 21px;
            }

            .tabla-contenedor {
                overflow-x: visible;
                border: none;
            }

            table {
                width: 100%;
                min-width: 0;
                display: block;
            }

            thead {
                display: none;
            }

            tbody {
                display: block;
                width: 100%;
            }

            tbody tr {
                display: block;
                margin-bottom: 14px;
                border: 1px solid var(--verde);
                border-radius: 8px;
                overflow: hidden;
            }

            tbody td {
                display: block;
                width: 100%;
                min-height: 40px;
                padding: 10px 8px 10px 35%;
                position: relative;
                text-align: right;
                overflow-wrap: anywhere;
                font-size: 13px;
                border-right: none;
                border-bottom: 1px solid var(--verde-oscuro);
            }

            tbody td::before {
                position: absolute;
                left: 8px;
                top: 10px;
                width: 30%;
                text-align: left;
                font-weight: bold;
                color: var(--verde);
            }

            tbody td:nth-child(1)::before {
                content: "#";
            }

            tbody td:nth-child(2)::before {
                content: "IP";
            }

            tbody td:nth-child(3)::before {
                content: "Estado";
            }

            tbody td:nth-child(4)::before {
                content: "Acciones";
            }

            tbody td[colspan] {
                padding: 14px;
                text-align: center;
            }

            tbody td[colspan]::before {
                content: none;
            }

            .acciones {
                flex-direction: column;
                gap: 8px;
                width: 100%;
            }

            .acciones form {
                width: 100%;
            }

            .acciones button {
                width: 100%;
                padding: 10px 5px;
                font-size: 12px;
                white-space: normal;
            }

            .formulario {
                flex-direction: column;
            }

            .formulario input,
            .btn-agregar {
                width: 100%;
                min-width: 0;
            }

            .btn-volver {
                display: block;
                text-align: center;
            }
        }
    </style>
</head>

<body>
<div class="contenedor">
    <div class="tarjeta">

        <h1>📋 MOROSOS</h1>

        {{-- MENSAJES DE ÉXITO --}}
        @if(session('mensaje'))
            <div class="mensaje success" role="status">
                {{ session('mensaje') }}
            </div>
        @endif

        {{-- ERRORES DE CONEXIÓN O CONSULTA --}}
        @if(!empty($error))
            <div class="mensaje error" role="alert">
                {{ $error }}
            </div>
        @endif

        {{-- ERRORES DE VALIDACIÓN --}}
        @if($errors->any())
            <div class="mensaje error" role="alert">
                @foreach($errors->all() as $errorValidacion)
                    <div>{{ $errorValidacion }}</div>
                @endforeach
            </div>
        @endif

        {{-- AGREGAR MOROSO --}}
        <form
            action="{{ route('mikrotik.morosos.agregar') }}"
            method="POST"
            class="formulario"
        >
            @csrf

            <input
                type="text"
                name="ip"
                placeholder="Ejemplo: 192.168.25.10"
                value="{{ old('ip') }}"
                aria-label="Dirección IP del moroso"
                required
            >

            <button type="submit" class="btn-agregar">
                ➕ AGREGAR IP
            </button>
        </form>

        {{-- TABLA DE MOROSOS --}}
        <div class="tabla-contenedor">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>IP</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($morosos as $moroso)
                        @php
                            $estaDeshabilitado = filter_var(
                                $moroso['disabled'] ?? false,
                                FILTER_VALIDATE_BOOLEAN
                            );

                            $idMoroso = $moroso['.id'] ?? null;
                        @endphp

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td class="ip">
                                {{ $moroso['address'] ?? 'Sin IP' }}
                            </td>

                            <td>
                                @if($estaDeshabilitado)
                                    <span class="estado-cortado">
                                        🔴 CORTADO
                                    </span>
                                @else
                                    <span class="estado-habilitado">
                                        🟢 HABILITADO
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="acciones">

                                    @if($idMoroso)
                                        {{-- HABILITAR O CORTAR --}}
                                        @if($estaDeshabilitado)
                                            <form
                                                action="{{ route('mikrotik.morosos.habilitar', ['id' => $idMoroso]) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                <button
                                                    type="submit"
                                                    class="btn-habilitar"
                                                >
                                                    🟢 HABILITAR
                                                </button>
                                            </form>
                                        @else
                                            <form
                                                action="{{ route('mikrotik.morosos.deshabilitar', ['id' => $idMoroso]) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                <button
                                                    type="submit"
                                                    class="btn-cortar"
                                                >
                                                    🔴 CORTAR
                                                </button>
                                            </form>
                                        @endif

                                        {{-- ELIMINAR --}}
                                        <form
                                            action="{{ route('mikrotik.morosos.eliminar', ['id' => $idMoroso]) }}"
                                            method="POST"
                                            onsubmit="return confirm('¿Seguro que quieres eliminar esta IP de MOROSOS?');"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn-eliminar"
                                            >
                                                🗑️ ELIMINAR
                                            </button>
                                        </form>
                                    @else
                                        <span class="estado-cortado">
                                            ID no disponible
                                        </span>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                No hay IPs agregadas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- VOLVER AL CONTROL DE INTERNET --}}
        <a
            href="{{ route('mikrotik.wifi') }}"
            class="btn-volver"
        >
            ← CONTROL DE INTERNET
        </a>

    </div>
</div>
</body>
</html>