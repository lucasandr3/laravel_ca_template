<?php

use App\Http\Controllers\AuthController;
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

//Route::get('/', function () {
//   return redirect()->route('login');
//});
//
//Route::get('/login', [AuthController::class, 'login'])->middleware('web')->name('login');
//Route::post('/makeLogin', [AuthController::class, 'makeLogin'])->name('login.auth');

// Rotas compra
include __DIR__ . '/compra.php';

// Rotas contrato
include __DIR__ . '/contrato.php';

// Rotas de arquivos
include __DIR__ . '/arquivos.php';

