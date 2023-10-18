<?php

namespace App\Adapters\Presenters\Pregao;

use App\Domain\Interfaces\Pregao\ViewModel;
use App\Domain\UseCases\Pregao\CreateProcessOutputPort;
use App\Domain\UseCases\Pregao\CreateProcessResponseModel;

class CreateProcessJsonPresenter implements CreateProcessOutputPort
{

    public function processCreated(CreateProcessResponseModel $model): ViewModel
    {
        echo "<pre>";var_dump('caiu aqui'); echo "</pre>";die;
    }

    public function processAlreadyExists(array $error): ViewModel
    {
        echo "<pre>";var_dump($error); echo "</pre>";die;
    }

    public function unableToCreateProcess(CreateProcessResponseModel $model, \Throwable $e): ViewModel
    {
        echo "<pre>";var_dump('caiu aqui'); echo "</pre>";die;
    }

}
