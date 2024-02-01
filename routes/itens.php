<?php

use App\Http\Controllers\Item\ItemController;
use Illuminate\Support\Facades\Route;

Route::prefix('item')->controller(ItemController::class)->group(function () {
    Route::put('compra/{codProcesso}', 'updateItems');
    Route::put('compra/{codProcesso}/item/{codItem}', 'updateOneItem');
    Route::get('compra/itens/{codProcesso}', 'readAll');
    Route::post('compra/resultado/{codProcesso}', 'sendResult');
});
