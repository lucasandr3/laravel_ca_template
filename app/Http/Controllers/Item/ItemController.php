<?php

namespace App\Http\Controllers\Item;

use App\Domain\UseCases\Item\InputItemRequest;
use App\Domain\UseCases\Item\InteractorItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function __construct(private readonly InteractorItem $interactor)
    {}

    public function updateItems(int $codProcesso)
    {
        return $this->interactor->updateItems(new InputItemRequest(['codProcesso' => $codProcesso]));
    }

    public function updateOneItem(int $codProcesso, int $codItem)
    {
        return $this->interactor->updateOneItem(new InputItemRequest([
            'codProcesso' => $codProcesso,
            'codItem' => $codItem
        ]));
    }

    public function readAll(int $codProcesso)
    {
        return $this->interactor->getAllItems(new InputItemRequest(['codProcesso' => $codProcesso]));
    }

    public function sendResult(int $codProcesso)
    {
        return $this->interactor->sendResult(new InputItemRequest([
            'codProcesso' => $codProcesso
        ]));
    }
}
