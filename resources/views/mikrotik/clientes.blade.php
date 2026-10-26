<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Panel de Clientes</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f4f6f8;
        }

        .header {
            background: #222;
            color: white;
            padding: 20px 40px;
        }

        .header h1 {
            margin: 0;
        }

        .container {
            padding: 30px 40px;
        }

        .cards {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            min-width: 220px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .card h2 {
            margin: 0 0 10px;
            font-size: 16px;
            color: #666;
        }

        .card p {
            margin: 0;
            font-size: 30px;
            font-weight: bold;
        }

        .boton {
            display: inline-block;
            padding: 10px 16px;
            background: #222;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #222;
            color: white;
        }

        .activo {
            color: green;
            font-weight: bold;
        }

        .deshabilitado {
            color: red;
            font-weight: bold;
        }

        .conectado {
            color: green;
            font-weight: bold;
        }

        .desconectado {
            color: #777;
        }

        .boton-detalles {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            background: #222;
            color: white;
            cursor: pointer;
        }

        .boton-detalles:hover {
            opacity: 0.8;
        }
        .buscador {
    margin-bottom: 20px;
}

.buscador input {
    width: 100%;
    max-width: 400px;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

.buscador input:focus {
    outline: none;
    border-color: #222;
}
    </style>
</head>

<body>

    <div class="header">
        <h1>Panel de Clientes</h1>
    </div>

    <div class="container">

        <div class="cards">

            <div class="card">
                <h2>Total de clientes</h2>
                <p>{{ $totalClientes }}</p>
            </div>

            <div class="card">
                <h2>Conectados</h2>
                <p>{{ $totalConectados }}</p>
            </div>

        </div>

        <a href="{{ url('/mikrotik/probar') }}" class="boton">
            Actualizar datos
        </a>
        <div class="buscador">
    <input
        type="text"
        id="buscarCliente"
        placeholder="Buscar cliente..."
        onkeyup="buscarCliente()">
</div>

        <table>

            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Servicio</th>
                    <th>Perfil</th>
                    <th>Estado</th>
                    <th>Conexión</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($clientes as $cliente)

                    <tr>

                        <td>
                            {{ $cliente['nombre'] }}
                        </td>

                        <td>
                            {{ $cliente['servicio'] }}
                        </td>

                        <td>
                            {{ $cliente['perfil'] }}
                        </td>

                        <td>
                            @if ($cliente['deshabilitado'] === 'true')
                                <span class="deshabilitado">
                                    Deshabilitado
                                </span>
                            @else
                                <span class="activo">
                                    Activo
                                </span>
                            @endif
                        </td>

                        <td>
                            @if ($cliente['conectado'])
                                <span class="conectado">
                                    Conectado
                                </span>
                            @else
                                <span class="desconectado">
                                    Desconectado
                                </span>
                            @endif
                        </td>

                        <td>
                            <a
    href="{{ url('/mikrotik/cliente/' . urlencode($cliente['nombre'])) }}"
    class="boton-detalles">
    Ver detalles
</a>
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>
   <script>
function buscarCliente() {

    const texto = document
        .getElementById('buscarCliente')
        .value
        .toLowerCase();

    const filas = document.querySelectorAll('tbody tr');

    filas.forEach(function(fila) {

        const nombre = fila
            .querySelector('td')
            .textContent
            .toLowerCase();

        if (nombre.includes(texto)) {
            fila.style.display = '';
        } else {
            fila.style.display = 'none';
        }

    });
}
</script>
</body>
</html>