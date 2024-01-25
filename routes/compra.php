<?php

use App\Http\Controllers\Dispensa\DispensaController;
use App\Http\Controllers\Orgao\OrgaoController;
use App\Http\Controllers\PregaoEletronico\PregaoEletronicoController;
use App\Http\Controllers\Unidade\UnidadeController;
use App\Http\Controllers\Usuario\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::prefix('processo/pregao')->controller(PregaoEletronicoController::class)->middleware('auth-use')->group(function () {
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

Route::prefix('unidades')->controller(UnidadeController::class)->middleware('auth-use')->group(function () {
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
