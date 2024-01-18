<?php

namespace App\Adapters\Presenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\Interfaces\PregaoEletronico\ViewModel;
use App\Domain\UseCases\PregaoEletronico\CreateProcessOutputPort;
use App\Domain\UseCases\PregaoEletronico\CreateProcessResponseModel;
use App\Http\Resources\PregaoEletronico\ProcessAlreadyExistsResource;
use App\Http\Resources\PregaoEletronico\ProcessCreatedResource;
use App\Http\Resources\PregaoEletronico\UnableToCreateProcessResource;

class CreateProcessJsonPresenter implements CreateProcessOutputPort
{
    public function ProcessCreated(CreateProcessResponseModel $model): ViewModel
    {
        return new JsonResourceViewModel(
            new ProcessCreatedResource($model->getProcess())
        );
    }

    public function processAlreadyExists(array $error): ViewModel
    {
        echo "<pre>"; var_dump($error); echo "</pre>"; die;
//        return new JsonResourceViewModel(
//            new ProcessAlreadyExistsResource($model->getProcess())
//        );
    }

    public function unableToCreateProcess(CreateProcessResponseModel $model, \Throwable $e): ViewModel
    {
        if (config('app.debug')) {
            // rethrow and let Laravel display the error
            throw $e;
        }

        return new JsonResourceViewModel(
            new UnableToCreateProcessResource($e)
        );
    }

    public function deletedProcess(array $responde)
    {
        // TODO: Implement deletedProcess() method.
    }

    public function unableToDeletedProcess(array $response, \Throwable $e): array
    {
        // TODO: Implement unableToDeletedProcess() method.
    }
}
