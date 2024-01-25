<?php

namespace App\Http\Controllers\Contrato;

use App\Domain\UseCases\Contrato\InputRequestContrato;
use App\Domain\UseCases\Contrato\InputRequestContratoArquivo;
use App\Domain\UseCases\Contrato\InteractorContrato;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contrato\CreateContractRequest;
use App\Http\Requests\Contrato\PostDocumentContractRequest;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    public function __construct(protected readonly InteractorContrato $interactorContrato)
    {}

    public function saveContract(CreateContractRequest $request)
    {
        return $this->interactorContrato->saveContract(new InputRequestContrato($request->all()));
    }

    public function rectifyContract()
    {

    }

    public function getContractByProcess()
    {

    }

    public function getContractByProcessAndVendor()
    {

    }

    public function historyContract()
    {

    }

    public function delContract()
    {

    }

    public function sendDocumentContract(PostDocumentContractRequest $request)
    {
        return $this->interactorContrato->sendDocumentContrato(new InputRequestContratoArquivo($request->all()));
    }

    public function allDocumentsContract()
    {

    }

    public function delDocumentContract()
    {

    }
}
