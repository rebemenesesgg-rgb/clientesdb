<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Clientes WiFi</title>


    <style>

        * {
            box-sizing: border-box;
        }


        /* =========================
           CUERPO
        ========================= */

        body {

            margin: 0;

            font-family: Arial, sans-serif;

            background: #050505;

            color: #ffffff;

            min-height: 100vh;
        }


        /* =========================
           BARRA SUPERIOR
        ========================= */

        .barra {

            background: #000000;

            border-bottom: 1px solid #242424;

            padding: 20px 40px;

            display: flex;

            justify-content: space-between;

            align-items: center;
        }


        .logo {

            font-size: 25px;

            font-weight: bold;

            letter-spacing: 2px;
        }


        .logo span {

            color: #45CF20;
        }


        .titulo-barra {

            color: #ffffff;

            font-size: 15px;
        }


        /* =========================
           CONTENEDOR
        ========================= */

        .contenedor {

            max-width: 1250px;

            margin: 40px auto;

            padding: 0 25px;
        }


        /* =========================
           ENCABEZADO
        ========================= */

        .encabezado {

            margin-bottom: 30px;
        }


        h1 {

            margin: 0;

            font-size: 32px;
        }


        .subtitulo {

            color: #999999;

            margin-top: 8px;

            font-size: 15px;
        }


        /* =========================
           MENSAJE
        ========================= */

        .mensaje {

            background: rgba(69, 207, 32, 0.10);

            border: 1px solid #45CF20;

            color: #45CF20;

            padding: 14px 18px;

            border-radius: 8px;

            margin-bottom: 25px;
        }


        /* =========================
           TABLA
        ========================= */

        .tabla-contenedor {

            background: #0D0D0D;

            border: 1px solid #242424;

            border-radius: 12px;

            overflow: hidden;
        }


        table {

            width: 100%;

            border-collapse: collapse;
        }


        th {

            background: #151515;

            color: #45CF20;

            padding: 16px;

            text-align: left;

            font-size: 13px;

            text-transform: uppercase;

            letter-spacing: 1px;

            border-bottom: 1px solid #242424;
        }


        td {

            padding: 16px;

            border-bottom: 1px solid #242424;

            color: #dddddd;

            vertical-align: middle;
        }


        tbody tr:last-child td {

            border-bottom: none;
        }


        tbody tr:hover td {

            background: #151515;
        }


        /* =========================
           BOTÓN EDITAR
        ========================= */

        .boton-editar {

            background: #45CF20;

            color: #000000;

            border: none;

            padding: 9px 16px;

            border-radius: 7px;

            cursor: pointer;

            font-weight: bold;

            transition: 0.2s;
        }


        .boton-editar:hover {

            background: #ffffff;

            transform: translateY(-1px);
        }


        /* =========================
           FORMULARIO DE ANCHO
        ========================= */

        .formulario-ancho {

            margin-top: 15px;

            padding: 18px;

            background: #050505;

            border: 1px solid #333333;

            border-radius: 8px;
        }


        .formulario-ancho label {

            color: #ffffff;

            font-size: 13px;

            font-weight: bold;

            margin-right: 5px;
        }


        .formulario-ancho input {

            width: 90px;

            padding: 9px;

            margin-right: 12px;

            background: #0D0D0D;

            color: #ffffff;

            border: 1px solid #333333;

            border-radius: 6px;

            outline: none;
        }


        .formulario-ancho input:focus {

            border-color: #45CF20;

            box-shadow: 0 0 0 2px rgba(69, 207, 32, 0.10);
        }


        /* =========================
           BOTÓN GUARDAR
        ========================= */

        .boton-guardar {

            background: #45CF20;

            color: #000000;

            border: none;

            padding: 9px 15px;

            border-radius: 6px;

            cursor: pointer;

            font-weight: bold;

            margin-top: 10px;

            transition: 0.2s;
        }


        .boton-guardar:hover {

            background: #ffffff;
        }


        /* =========================
           DATOS DE VELOCIDAD
        ========================= */

        .velocidad {

            color: #45CF20;

            font-weight: bold;
        }


        .ip {

            color: #bbbbbb;

            font-family: monospace;
        }


        .id {

            color: #777777;

            font-family: monospace;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            .barra {

                padding: 20px;
            }


            .titulo-barra {

                display: none;
            }


            .contenedor {

                margin-top: 25px;

                padding: 0 15px;
            }


            .tabla-contenedor {

                overflow-x: auto;
            }


            table {

                min-width: 900px;
            }
        }

    </style>

</head>


<body>


    <!-- =========================
         BARRA SUPERIOR
    ========================== -->

    <div class="barra">

        <div class="logo">

            TV<span>+</span>

        </div>


        <div class="titulo-barra">

            Administración de clientes WiFi

        </div>

    </div>



    <!-- =========================
         CONTENIDO
    ========================== -->

    <div class="contenedor">


        <div class="encabezado">

            <h1>
                Clientes WiFi
            </h1>


            <div class="subtitulo">

                Administración de direcciones IP y velocidad de conexión

            </div>

        </div>



        <!-- MENSAJE -->

        @if (session('mensaje'))

            <div class="mensaje">

                {{ session('mensaje') }}

            </div>

        @endif



        <!-- TABLA -->

        <div class="tabla-contenedor">

            <table>

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Cliente</th>

                        <th>IP</th>

                        <th>Upload</th>

                        <th>Download</th>

                        <th>Acción</th>

                    </tr>

                </thead>


                <tbody>


                    @foreach ($queues as $queue)


                        @php

                            $limite = $queue['max-limit'] ?? '0/0';

                            $velocidades = explode('/', $limite);

                            $upload = ($velocidades[0] ?? 0) / 1000000;

                            $download = ($velocidades[1] ?? 0) / 1000000;

                        @endphp


                        <tr>


                            <!-- ID -->

                            <td>

                                <span class="id">

                                    {{ $queue['.id'] ?? 'Sin ID' }}

                                </span>

                            </td>



                            <!-- CLIENTE -->

                            <td>

                                {{ $queue['name'] ?? 'Sin nombre' }}

                            </td>



                            <!-- IP -->

                            <td>

                                <span class="ip">

                                    {{ $queue['target'] ?? 'Sin IP' }}

                                </span>

                            </td>



                            <!-- UPLOAD -->

                            <td>

                                <span class="velocidad">

                                    {{ $upload }} Mbps

                                </span>

                            </td>



                            <!-- DOWNLOAD -->

                            <td>

                                <span class="velocidad">

                                    {{ $download }} Mbps

                                </span>

                            </td>



                            <!-- ACCIÓN -->

                            <td>


                                <button
                                    type="button"
                                    class="boton-editar"
                                    onclick="mostrarFormulario('{{ $queue['.id'] }}')"
                                >

                                    Editar

                                </button>



                                <div
                                    id="form-{{ $queue['.id'] }}"
                                    class="formulario-ancho"
                                    style="display: none;"
                                >


                                    <form
                                        method="POST"
                                        action="/mikrotik/cambiar-ancho"
                                    >

                                        @csrf


                                        <input
                                            type="hidden"
                                            name="id"
                                            value="{{ $queue['.id'] }}"
                                        >



                                        <label>

                                            Upload:

                                        </label>


                                        <input
                                            type="number"
                                            name="upload"
                                            value="{{ $upload }}"
                                            min="0"
                                            step="0.1"
                                            required
                                        >



                                        <label>

                                            Download:

                                        </label>


                                        <input
                                            type="number"
                                            name="download"
                                            value="{{ $download }}"
                                            min="0"
                                            step="0.1"
                                            required
                                        >



                                        <br>


                                        <button
                                            type="submit"
                                            class="boton-guardar"
                                        >

                                            Guardar cambios

                                        </button>


                                    </form>


                                </div>


                            </td>


                        </tr>


                    @endforeach


                </tbody>


            </table>

        </div>


    </div>



    <!-- =========================
         JAVASCRIPT
    ========================== -->

    <script>

        function mostrarFormulario(id)
        {
            const formulario =
                document.getElementById('form-' + id);


            if (formulario.style.display === 'none') {

                formulario.style.display = 'block';

            } else {

                formulario.style.display = 'none';

            }
        }

    </script>


</body>

</html>