<?php

use App\Http\Controllers\Contrato\ContratoController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aqui é onde você pode registrar rotas de API para seu aplicativo.
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rotas compra
include __DIR__ . '/compra.php';

// Rotas contrato
include __DIR__ . '/contrato.php';

