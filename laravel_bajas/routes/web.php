<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\bajasController;


use App\Mail\EnviarMail;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', [bajasController::class, 'index']);
//se accede a bajasController (hay que pasar el use), y se va a index, que sería el método

Route::get('/baja/{id_baja}', [bajasController::class, 'baja']);

Route::get('/cuestionarioBaja', [bajasController::class, 'cuestionarioBaja']);

Route::post('/insertarBaja', [bajasController::class, 'insertarBaja']);