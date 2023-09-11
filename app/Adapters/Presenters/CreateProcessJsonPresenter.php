<?php

namespace App\Adapters\Presenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\Interfaces\PregaoNovaLei\ViewModel;
use App\Domain\UseCases\PregaoNovaLei\CreateProcessOutputPort;
use App\Domain\UseCases\PregaoNovaLei\CreateProcessResponseModel;
use App\Http\Resources\PregaoNovaLei\ProcessAlreadyExistsResource;
use App\Http\Resources\PregaoNovaLei\ProcessCreatedResource;
use App\Http\Resources\PregaoNovaLei\UnableToCreateProcessResource;

class CreateProcessJsonPresenter implements CreateProcessOutputPort
{
    public function ProcessCreated(CreateProcessResponseModel $model): ViewModel
    {
        return new JsonResourceViewModel(
            new ProcessCreatedResource($model->getProcess())
        );
    }

    public function processAlreadyExists(CreateProcessResponseModel $model): ViewModel
    {
        return new JsonResourceViewModel(
            new ProcessAlreadyExistsResource($model->getProcess())
        );
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
}
