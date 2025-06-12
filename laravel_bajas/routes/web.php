<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\bajasWebController;
use App\Http\Controllers\bajasApiController;

use App\Mail\EnviarMail;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', [bajasWebController::class, 'index']);
//se accede a bajasController (hay que pasar el use), y se va a index, que sería el método

Route::get('/baja/{id_baja}', [bajasWebController::class, 'baja']);

Route::get('/cuestionarioBaja', [bajasWebController::class, 'cuestionarioBaja']);

Route::post('/insertarBaja', [bajasWebController::class, 'insertarBaja']);

Route::get('/cancelarBaja/{id_baja}', [bajasWebController::class, 'cancelarBaja']);


//las rutas json
Route::prefix('api')->group(function () {
    Route::get('/bajas', [bajasApiController::class, 'index']);
    Route::get('/baja/{id_baja}', [bajasApiController::class, 'baja']);
    Route::get('/cuestionarioBaja', [bajasApiController::class, 'cuestionarioBaja']);
    Route::post('/insertarBaja', [bajasApiController::class, 'insertarBaja']);
    Route::get('/cancelarBaja/{id_baja}', [bajasApiController::class, 'cancelarBaja']);
});