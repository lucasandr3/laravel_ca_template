<?php

namespace App\Adapters\Presenters\PregaoEletronico;

use App\Domain\Interfaces\PregaoEletronico\ViewModel;
use App\Domain\UseCases\PregaoEletronico\CreateProcessOutputPort;
use App\Domain\UseCases\PregaoEletronico\CreateProcessResponseModel;

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
