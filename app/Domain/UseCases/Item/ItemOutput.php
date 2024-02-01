<?php

namespace App\Domain\UseCases\Item;

use App\Domain\Interfaces\PregaoEletronico\ViewModel;
use App\Domain\UseCases\PregaoEletronico\CreateProcessResponseModel;

interface ItemOutput
{
    public function notFoundResource();

    public function notFoundPurchaseResource();

    public function notFoundExternalResource();

    public function notFoundFileResource();

    public function unableUploaded(string $result);

    public function unableDeleted(string $result);

    public function success();

    public function successPostResult();

    public function created();

    public function deleted();

    public function error(string $result);

    public function itens(string $result);
}
