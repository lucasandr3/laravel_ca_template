<?php

use App\Http\Controllers\Dispensa\DispensaController;
use App\Http\Controllers\Pregao\CreatePregaoNovaLeiController;
use App\Http\Controllers\Pregao\PregaoNovaLeiController;
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


Route::prefix('process/pregao')->controller(PregaoNovaLeiController::class)->group(function () {
    Route::post('{id}', 'create');
    Route::delete('{id}',  'delete');
});

Route::prefix('process/dispensa')->controller(DispensaController::class)->group(function () {
    Route::post('{id}', 'create');
    Route::delete('{id}', 'delete');
});

//Route::prefix('process')->controller(CreatePregaoNovaLeiController::class)->group(function () {
//   Route::post('', );
//});
