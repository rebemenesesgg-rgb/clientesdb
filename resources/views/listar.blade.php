<!DOCTYPE html>
<html>

<head>

    <title>Lista de Clientes</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>


<body class="bg-light">


<div class="container-fluid mt-5 mb-5">

    <div class="card shadow">

        <!-- ENCABEZADO -->

        <div class="card-header bg-dark text-white">

            <div class="d-flex justify-content-between align-items-center">

                <h3 class="mb-0">
                    Lista de Clientes
                </h3>

                <span>
                    Control de pagos
                </span>

            </div>

        </div>


        <div class="card-body">


            <!-- MENSAJE DE ÉXITO -->

            @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

            @endif


            <!-- BOTÓN NUEVO CLIENTE -->

            <a
                href="/clientes/crear"
                class="btn btn-success mb-3"
            >
                + Nuevo Cliente
            </a>


            <!-- TABLA -->

            <div class="table-responsive">

                <table class="table table-striped table-hover table-bordered align-middle">

                    <thead class="table-secondary">

                        <tr>

                            <th>ID</th>

                            <th>Nombre</th>

                            <th>Correo</th>

                            <th>Teléfono</th>

                            <th>Dirección</th>

                            <th>Mayo</th>

                            <th>Junio</th>

                            <th>Julio</th>

                            <th>Agosto</th>

                            <th>Septiembre</th>

                            <th>Octubre</th>

                            <th>Noviembre</th>

                            <th>Diciembre</th>

                            <th>Notas</th>

                            <th>Acciones</th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($clientes as $cliente)

                        <tr>

                            <!-- ID -->

                            <td>
                                {{ $cliente->id }}
                            </td>


                            <!-- NOMBRE -->

                            <td>
                                {{ $cliente->nombre }}
                            </td>


                            <!-- CORREO -->

                            <td>
                                {{ $cliente->correo ?? '—' }}
                            </td>


                            <!-- TELEFONO -->

                            <td>
                                {{ $cliente->telefono ?? '—' }}
                            </td>


                            <!-- DIRECCION -->

                            <td>
                                {{ $cliente->direccion ?? '—' }}
                            </td>


                            <!-- MAYO -->

                            <td>
                                {{ $cliente->may ?? '—' }}
                            </td>


                            <!-- JUNIO -->

                            <td>
                                {{ $cliente->jun ?? '—' }}
                            </td>


                            <!-- JULIO -->

                            <td>
                                {{ $cliente->jul ?? '—' }}
                            </td>


                            <!-- AGOSTO -->

                            <td>
                                {{ $cliente->agos ?? '—' }}
                            </td>


                            <!-- SEPTIEMBRE -->

                            <td>
                                {{ $cliente->sep ?? '—' }}
                            </td>


                            <!-- OCTUBRE -->

                            <td>
                                {{ $cliente->oct ?? '—' }}
                            </td>


                            <!-- NOVIEMBRE -->

                            <td>
                                {{ $cliente->nov ?? '—' }}
                            </td>


                            <!-- DICIEMBRE -->

                            <td>
                                {{ $cliente->dic ?? '—' }}
                            </td>


                            <!-- NOTAS -->

                            <td>
                                {{ $cliente->notas ?? '—' }}
                            </td>


                            <!-- ACCIONES -->

                            <td>

                                <div class="d-flex gap-1">

                                    <a
                                        href="/clientes/editar/{{ $cliente->id }}"
                                        class="btn btn-warning btn-sm"
                                    >
                                        Editar
                                    </a>


                                    <a
                                        href="/clientes/eliminar/{{ $cliente->id }}"
                                        class="btn btn-danger btn-sm"
                                    >
                                        Eliminar
                                    </a>

                                </div>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


</body>

</html>