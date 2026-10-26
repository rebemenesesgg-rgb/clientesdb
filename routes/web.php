<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FacturaController;

Route::get('/', function () {
    return redirect('/clientes/listar');
});

Route::get('/clientes/crear', [ClienteController::class, 'crear']);

Route::post('/clientes/guardar', [ClienteController::class, 'guardar']);

Route::get('/clientes/listar', [ClienteController::class, 'listar']);

Route::get('/clientes/editar/{id}', [ClienteController::class, 'editar']);

Route::post('/clientes/actualizar/{id}', [ClienteController::class, 'actualizar']);

Route::get('/clientes/eliminar/{id}', [ClienteController::class, 'borrar']);

use App\Http\Controllers\MikroTikController;

Route::get('/mikrotik/probar', [MikroTikController::class, 'probar']);
Route::get('/mikrotik/activos', [MikroTikController::class, 'activos']);
Route::get('/mikrotik/cliente/{nombre}', [MikroTikController::class, 'detalle']);
Route::post('/mikrotik/cliente/{nombre}/cortar', [MikroTikController::class, 'cortar']);
Route::post('/mikrotik/cambiar-ancho', [MikroTikController::class, 'cambiarAncho']);
Route::get('/mikrotik/clientes-wifi', [MikroTikController::class, 'clientesWifi']);
Route::get('/mikrotik/listarPPoe', [MikroTikController::class, 'listarPPoe']);
Route::get('/mikrotik/crearPPoe', [MikroTikController::class, 'mostrarCrearPPoe']);
Route::post('/mikrotik/crearPPoe', [MikroTikController::class, 'crearPPoe']);



/*
|--------------------------------------------------------------------------
| FACTURAS
|--------------------------------------------------------------------------
*/

//Route::resource('facturas', FacturaController::class);


/*
|--------------------------------------------------------------------------
| CONTROL DE INTERNET
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Mostrar tabla de control de Internet
|--------------------------------------------------------------------------
*/

Route::get('/mikrotik/wifi', [MikroTikController::class, 'wifi'])
    ->name('mikrotik.wifi');


/*
|--------------------------------------------------------------------------
| Agregar IP
|--------------------------------------------------------------------------
*/

Route::post('/mikrotik/wifi/agregar-ip', [MikroTikController::class, 'agregarIp'])
    ->name('mikrotik.wifi.agregar');


/*
|--------------------------------------------------------------------------
| Habilitar Internet
|--------------------------------------------------------------------------
*/

Route::post('/mikrotik/wifi/{id}/habilitar', [MikroTikController::class, 'enableWifi'])
    ->name('mikrotik.wifi.enable');


/*
|--------------------------------------------------------------------------
| Cortar servicio
|--------------------------------------------------------------------------
*/

Route::post('/mikrotik/wifi/{id}/cortar', [MikroTikController::class, 'disableWifi'])
    ->name('mikrotik.wifi.disable');


/*
|--------------------------------------------------------------------------
| Deshabilitar / eliminar IP
|--------------------------------------------------------------------------
*/

Route::post('/mikrotik/wifi/{id}/deshabilitar', [MikroTikController::class, 'deshabilitarWifi'])
    ->name('mikrotik.wifi.deshabilitar');


/*
|--------------------------------------------------------------------------
| USUARIOS PPP
|--------------------------------------------------------------------------
*/

Route::get('/mikrotik', [MikroTikController::class, 'ppp'])
    ->name('mikrotik.ppp');


Route::post('/mikrotik/ppp/habilitar/{id}', [MikroTikController::class, 'habilitarPPP'])
    ->name('mikrotik.ppp.habilitar');


Route::post('/mikrotik/ppp/deshabilitar/{id}', [MikroTikController::class, 'deshabilitarPPP'])
    ->name('mikrotik.ppp.deshabilitar');


/*
|--------------------------------------------------------------------------
| MOROSOS
|--------------------------------------------------------------------------
*/

/*
| Mostrar tabla de morosos
*/

Route::get('/morosos', [MikroTikController::class, 'morosos'])
    ->name('mikrotik.morosos');


/*
| Agregar moroso
*/

Route::post('/morosos/agregar', [MikroTikController::class, 'agregarMoroso'])
    ->name('mikrotik.morosos.agregar');


/*
| Habilitar moroso
*/

Route::post('/morosos/habilitar/{id}', [MikroTikController::class, 'habilitarMoroso'])
    ->name('mikrotik.morosos.habilitar');


/*
| Deshabilitar / cortar moroso
*/

Route::post('/morosos/deshabilitar/{id}', [MikroTikController::class, 'deshabilitarMoroso'])
    ->name('mikrotik.morosos.deshabilitar');


/*
| Eliminar moroso
*/

Route::delete('/morosos/eliminar/{id}', [MikroTikController::class, 'eliminarMoroso'])
    ->name('mikrotik.morosos.eliminar');