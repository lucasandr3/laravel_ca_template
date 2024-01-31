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

    public function read($codProcess)
    {
        return $this->interactor->getProcess(new InputRequest([], $codProcess));
    }

    public function create(CreatePregaoEletronicoRequest $request, $codProcess)
    {
        return $this->interactor->createProcess(new InputRequest([], $codProcess));
    }

    public function update($codProcesso)
    {
        return $this->interactor->updateProcesso(new InputRequest([], $codProcesso));
    }

    public function delete(DeletePregaoEletronicoRequest $request, $codProcess)
    {
        return $this->interactor->deleteProcess(new InputRequest($request->all(), $codProcess));
    }
}
