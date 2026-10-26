<!DOCTYPE html>
<html>
<head>
    <title>Editar Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-warning">
            <h3>Editar Cliente</h3>
        </div>

        <div class="card-body">

            <form action="/clientes/actualizar/{{ $cliente->id }}" method="POST">

                @csrf

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input
                        type="text"
                        name="nombre"
                        class="form-control"
                        value="{{ $cliente->nombre }}"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Correo</label>
                    <input
                        type="email"
                        name="correo"
                        class="form-control"
                        value="{{ $cliente->correo }}"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Teléfono</label>
                    <input
                        type="text"
                        name="telefono"
                        class="form-control"
                        value="{{ $cliente->telefono }}"
                        required>
                </div>

                <button type="submit" class="btn btn-warning">
                    Actualizar
                </button>

                <a href="/clientes/listar" class="btn btn-secondary">
                    Cancelar
                </a>

            </form>

        </div>

    </div>

</div>

</body>
</html>