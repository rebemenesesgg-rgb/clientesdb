<!DOCTYPE html>
<html>
<head>
    <title>Crear Cliente</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5 mb-5">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Crear Cliente</h3>
        </div>

        <div class="card-body">

            <form action="/clientes/guardar" method="POST">

                @csrf

                <!-- DATOS DEL CLIENTE -->

                <h5 class="mb-3">Datos del cliente</h5>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Nombre
                        </label>

                        <input
                            type="text"
                            name="nombre"
                            class="form-control"
                            required
                        >

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Correo
                        </label>

                        <input
                            type="email"
                            name="correo"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Teléfono
                        </label>

                        <input
                            type="text"
                            name="telefono"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Dirección
                        </label>

                        <input
                            type="text"
                            name="direccion"
                            class="form-control"
                        >

                    </div>

                </div>


                <!-- CONTROL DE PAGOS -->

                <hr>

                <h5 class="mb-3">
                    Control de pagos
                </h5>

                <div class="row">

                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Mayo
                        </label>

                        <input
                            type="text"
                            name="may"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Junio
                        </label>

                        <input
                            type="text"
                            name="jun"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Julio
                        </label>

                        <input
                            type="text"
                            name="jul"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Agosto
                        </label>

                        <input
                            type="text"
                            name="agos"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Septiembre
                        </label>

                        <input
                            type="text"
                            name="sep"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Octubre
                        </label>

                        <input
                            type="text"
                            name="oct"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Noviembre
                        </label>

                        <input
                            type="text"
                            name="nov"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Diciembre
                        </label>

                        <input
                            type="text"
                            name="dic"
                            class="form-control"
                        >

                    </div>

                </div>


                <!-- NOTAS -->

                <hr>

                <div class="mb-3">

                    <label class="form-label">
                        Notas
                    </label>

                    <textarea
                        name="notas"
                        class="form-control"
                        rows="3"
                    ></textarea>

                </div>


                <!-- BOTONES -->

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Guardar Cliente
                </button>


                <a
                    href="/clientes/listar"
                    class="btn btn-secondary"
                >
                    Volver
                </a>

            </form>

        </div>

    </div>

</div>

</body>
</html>