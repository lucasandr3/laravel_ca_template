<?php

namespace App\Adapters\Presenters\Dispensa;

use App\Adapters\ViewModels\JsonResourceModel;
use App\Domain\Interfaces\Pregao\ViewModel;
use App\Domain\UseCases\Dispensa\DispensaResponseModel;
use App\Domain\UseCases\Dispensa\OutputPort;

class DispensaJsonPresenter implements OutputPort
{

    public function processCreated(DispensaResponseModel $model)
    {
        return new JsonResourceModel($model);
    }

    public function processAlreadyExists(array $error)
    {
        echo "<pre>";var_dump($error); echo "</pre>";die;
    }

    public function unableToCreateProcess(DispensaResponseModel $model, \Throwable $e)
    {
        echo "<pre>";var_dump('caiu aqui'); echo "</pre>";die;
    }
}
