<?php

namespace App\Http\Controllers\PregaoEletronico;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\UseCases\PregaoEletronico\CreateProcessInteractor;
use App\Domain\UseCases\PregaoEletronico\InputRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\PregaoEletronico\CreatePregaoEletronicoRequest;
use App\Http\Requests\PregaoEletronico\DeletePregaoEletronicoRequest;

class PregaoEletronicoController extends Controller
{
    public function __construct(private CreateProcessInteractor $interactor) {}

    public function create(CreatePregaoEletronicoRequest $request, $codProcess)
    {
        $viewModel = $this->interactor->createProcess(
            new InputRequest([], $codProcess)
        );

        if ($viewModel instanceof JsonResourceViewModel) {
            return $viewModel->getResource();
        }

        return null;
    }

    public function delete(DeletePregaoEletronicoRequest $request, $codProcess)
    {
        $response = $this->interactor->deleteProcess(
            new InputRequest($request->all(), $codProcess)
        );

        if ($response instanceof JsonResourceViewModel) {
            return $response->getResource();
        }

        return null;
    }
}
