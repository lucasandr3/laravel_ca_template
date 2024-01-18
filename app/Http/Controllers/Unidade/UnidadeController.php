<?php

namespace App\Http\Controllers\Unidade;

use App\Domain\UseCases\Unidade\InputRequestUnidade;
use App\Domain\UseCases\Unidade\InteractorUnidade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Unidade\CreateUnidadeRequest;
use App\Http\Requests\Unidade\UpdateUnidadeRequest;
use Illuminate\Http\Request;

class UnidadeController extends Controller
{
    public function __construct(private readonly InteractorUnidade $interactor)
    {}

    public function create(CreateUnidadeRequest $request)
    {
        return $this->interactor->createUnidade(new InputRequestUnidade($request->all()));
    }

    public function readAll(string $documento)
    {
        return $this->interactor->getUnidades(new InputRequestUnidade(['cnpj' => $documento]));
    }

    public function readById(string $codigoUnidade)
    {
        return $this->interactor->getUnidadePorCodigo(new InputRequestUnidade(['codigo' => $codigoUnidade]));
    }

    public function update(UpdateUnidadeRequest $request)
    {
        return $this->interactor->updateUnidade(new InputRequestUnidade($request->all()));
    }
}
