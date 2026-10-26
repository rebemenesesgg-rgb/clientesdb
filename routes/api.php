<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Cliente;

Route::get('/clientes', function () {

    $clientes = Cliente::all();

    return response()->json($clientes);

});

Route::post('/clientes', function (Request $request) {

    $cliente = Cliente::create([
        'nombre' => $request->nombre,
        'correo' => $request->correo,
        'telefono' => $request->telefono,
        'direccion' => $request->direccion,
        'may' => $request->may,
        'jun' => $request->jun,
        'jul' => $request->jul,
        'agos' => $request->agos,
        'sep' => $request->sep,
        'oct' => $request->oct,
        'nov' => $request->nov,
        'dic' => $request->dic,
        'notas' => $request->notas
    ]);

    return response()->json([
        'mensaje' => 'Cliente guardado correctamente',
        'cliente' => $cliente
    ], 201);

});