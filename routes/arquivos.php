<?php

use App\Http\Controllers\Arquivo\ArquivoController;
use Illuminate\Support\Facades\Route;

Route::prefix('arquivo')->controller(ArquivoController::class)->group(function () {
    Route::post('compra/{codProcesso}/documento/{codDocumento}', 'newDocument');
    Route::delete('compra/{codProcesso}/sequencial/{sequencial}', 'deleteDocument');
});
