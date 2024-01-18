<?php

use App\Http\Controllers\Dispensa\DispensaController;
use App\Http\Controllers\Orgao\OrgaoController;
use App\Http\Controllers\PregaoEletronico\PregaoEletronicoController;
use App\Http\Controllers\Unidade\UnidadeController;
use App\Http\Controllers\Usuario\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('processo/pregao')->controller(PregaoEletronicoController::class)->group(function () {
    Route::post('{id}', 'create');
    Route::get('{id}',  'read');
    Route::put('{id}',  'update');
    Route::delete('{id}',  'delete');
});

Route::prefix('processo/dispensa')->controller(DispensaController::class)->group(function () {
    Route::post('{id}', 'create');
    Route::delete('{id}', 'delete');
});

Route::prefix('orgaos')->controller(OrgaoController::class)->group(function () {
    Route::post('', 'create');
    Route::put('', 'update');
    Route::get('documento/{document}', 'readByDocument');
    Route::get('codigo/{id}', 'readById');
    Route::get('', 'readAll');
});

Route::prefix('unidades')->controller(UnidadeController::class)->group(function () {
    Route::post('', 'create');
    Route::put('codigo/{codigo}', 'update');
    Route::get('codigo/{codigo}', 'readById');
    Route::get('{document}', 'readAll');
});

Route::prefix('usuario')->controller(UsuarioController::class)->group(function () {
    Route::get('', 'read');
    Route::get('autorizados', 'getEntitiesAuthorized');
    Route::post('logar', 'authentication');
    Route::put('', 'updateEntities');
});
