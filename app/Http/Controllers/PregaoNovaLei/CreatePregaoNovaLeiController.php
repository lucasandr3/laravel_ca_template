<?php

namespace App\Http\Controllers\PregaoNovaLei;

use App\Domain\UseCases\PregaoNovaLei\CreateProcessInteractor;
use App\Domain\UseCases\PregaoNovaLei\CreateProcessRequestModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\PregaoNovaLei\CreatePregaoNovaLeiRequest;

class CreatePregaoNovaLeiController extends Controller
{
    public function __construct(private CreateProcessInteractor $interactor) {}

    public function __invoke(CreatePregaoNovaLeiRequest $request, $codProcess)
    {
        $viewModel = $this->interactor->createProcess(
            new CreateProcessRequestModel((int)$codProcess)
        );

        echo "<pre>"; var_dump($viewModel); echo "</pre>"; die;
//
//        if ($viewModel instanceof JsonResourceViewModel) {
//            return $viewModel->getResource();
//        }
//
//        return null;
    }
}
