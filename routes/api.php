<?php

use App\Http\Controllers\AdicionalController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DetalleOrdenController;
use App\Http\Controllers\DetalleProductoController;
use App\Http\Controllers\EnvioController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ResumenController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::resource('producto', ProductoController::class);
    Route::resource('detalle_producto', DetalleProductoController::class);
    Route::resource('adicional', AdicionalController::class);
    Route::resource('cliente', ClienteController::class);
    Route::resource('usuario', UsuarioController::class);
    Route::resource('rol', RolController::class);
    Route::resource('direccion', DireccionController::class);
    Route::resource('carrito', CarritoController::class);
    Route::resource('resumen', ResumenController::class);
    Route::resource('orden', OrdenController::class);
    Route::resource('modo_pago', ModoPagoController::class);
    Route::resource('detalle_orden', DetalleOrdenController::class);
    Route::resource('envio', EnvioController::class);
    Route::resource('empleado', EmpleadoController::class);
    Route::resource('ubicacion', UbicacionController::class);
});
