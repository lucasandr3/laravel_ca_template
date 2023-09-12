<?php

namespace App\Adapters\Presenters\PregaoNovaLei;

use App\Domain\Interfaces\PregaoNovaLei\ViewModel;
use App\Domain\UseCases\PregaoNovaLei\CreateProcessOutputPort;
use App\Domain\UseCases\PregaoNovaLei\CreateProcessResponseModel;

class CreateProcessJsonPresenter implements CreateProcessOutputPort
{

    public function processCreated(CreateProcessResponseModel $model): ViewModel
    {
        echo "<pre>";var_dump('caiu aqui'); echo "</pre>";die;
    }

    public function processAlreadyExists(CreateProcessResponseModel $model): ViewModel
    {
        echo "<pre>";var_dump('caiu aqui'); echo "</pre>";die;
    }

    public function unableToCreateProcess(CreateProcessResponseModel $model, \Throwable $e): ViewModel
    {
        echo "<pre>";var_dump('caiu aqui'); echo "</pre>";die;
    }
}
