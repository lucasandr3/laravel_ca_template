<?php

use App\Http\Controllers\Contrato\ContratoController;
use Illuminate\Support\Facades\Route;

Route::prefix('contrato')->controller(ContratoController::class)->group(function () {
    Route::post('', 'saveContract');
    Route::put('retificar', 'rectifyContract');
    Route::get('compra/{processId:[0-9]+}', 'getPurchaseByProcess');
    Route::get('compra/log/{processId:[0-9]+}', 'getLogByPurchase');
    Route::get('compra/contrato/{processId:[0-9]+}', 'getContractByProcess');
    Route::get('compra/contrato/{processId:[0-9]+}/fornecedor/{fornecedor:[0-9]+}', 'getContractByProcessAndVendor');
    Route::get('compra/historico/{processId:[0-9]+}/contrato/{contrato:[0-9]+}', 'historyContract');
    Route::delete('excluir', 'delContract');

    Route::post('arquivos', 'sendDocumentContract');
    Route::get('arquivos/{processId:[0-9]+}/contrato/{contrato:[0-9]+}', 'allDocumentsContract');
    Route::delete('arquivos/excluir/documento', 'delDocumentContract');
});
