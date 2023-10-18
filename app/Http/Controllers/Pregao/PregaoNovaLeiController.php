<?php

namespace App\Http\Controllers\Pregao;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\UseCases\Pregao\CreateProcessInteractor;
use App\Domain\UseCases\Pregao\InputRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pregao\CreatePregaoNovaLeiRequest;
use App\Http\Requests\Pregao\DeletePregaoNovaLeiRequest;

class PregaoNovaLeiController extends Controller
{
    public function __construct(private CreateProcessInteractor $interactor) {}

    public function create(CreatePregaoNovaLeiRequest $request, $codProcess)
    {
        $viewModel = $this->interactor->createProcess(
            new InputRequest(['cod_pregao' => $codProcess])
        );

        if ($viewModel instanceof JsonResourceViewModel) {
            return $viewModel->getResource();
        }

        return null;
    }

    public function delete(DeletePregaoNovaLeiRequest $request, $codProcess)
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
