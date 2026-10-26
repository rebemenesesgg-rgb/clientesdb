<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    public function crear()
    {
        return view('crear');
    }

    public function guardar(Request $request)
    {
        Cliente::create([
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

        return redirect('/clientes/listar')
            ->with('success', 'Cliente guardado correctamente');
    }

    public function listar()
    {
        $clientes = Cliente::all();

        return view('listar', compact('clientes'));
    }

    public function editar($id)
    {
        $cliente = Cliente::find($id);

        return view('editar', compact('cliente'));
    }

    public function actualizar(Request $request, $id)
    {
        $cliente = Cliente::find($id);

        $cliente->update([
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

        return redirect('/clientes/listar')
            ->with('success', 'Cliente actualizado correctamente');
    }

    public function borrar($id)
    {
        $cliente = Cliente::find($id);

        if ($cliente) {
            $cliente->delete();
        }

        return redirect('/clientes/listar')
            ->with('success', 'Cliente eliminado correctamente');
    }
}
