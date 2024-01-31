<?php

namespace App\Http\Controllers\Arquivo;

use App\Domain\UseCases\Arquivo\InputArquivoRequest;
use App\Domain\UseCases\Arquivo\InteractorArquivo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArquivoController extends Controller
{
    public function __construct(private readonly InteractorArquivo $interactor)
    {}

    public function newDocument(int $codProcesso, int $codDocumento)
    {
        return $this->interactor->sendDocument(new InputArquivoRequest([
            'codProcesso' => $codProcesso,
            'codDocumento' => $codDocumento]
        ));
    }

    public function deleteDocument(int $codProcesso, int $sequencial)
    {
        return $this->interactor->deleteDocument(new InputArquivoRequest([
            'codProcesso' => $codProcesso,
            'sequencial' => $sequencial
        ]));
    }
}
