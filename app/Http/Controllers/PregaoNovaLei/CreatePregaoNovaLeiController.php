<?php

namespace App\Http\Controllers\PregaoNovaLei;

use App\Domain\UseCases\PregaoNovaLei\CreateProcessInputPort;
use App\Domain\UseCases\PregaoNovaLei\CreateProcessInteractor;
use App\Http\Controllers\Controller;
use App\Http\Requests\PregaoNovaLei\CreatePregaoNovaLeiRequest;
use Illuminate\Support\Fluent;

class CreatePregaoNovaLeiController extends Controller
{
    public function __construct(
        private CreateProcessInteractor $interactor
    ) {}

    public function __invoke(CreatePregaoNovaLeiRequest $request)
    {
        echo "<pre>"; var_dump("aqio"); echo "</pre>"; die;
//        $viewModel = $this->interactor->createProcess(
//            new CreateProcessRequestModel($request->validated())
//        );
//
//        if ($viewModel instanceof JsonResourceViewModel) {
//            return $viewModel->getResource();
//        }
//
//        return null;
    }
}
