<?php

namespace App\Http\Controllers\Orgao;

use App\Adapters\Presenters\Orgao\OrgaoJsonPresenter;
use App\Domain\UseCases\Orgao\InputRequestOrgao;
use App\Domain\UseCases\Orgao\InteractorOrgao;
use App\Http\Controllers\Controller;
use App\Http\Requests\Orgao\CreateOrgaoRequest;
use App\Http\Requests\Orgao\UpdateOrgaoRequest;
use Illuminate\Http\Request;

class OrgaoController extends Controller
{
    public function __construct(private readonly InteractorOrgao $interactor)
    {}

    public function create(CreateOrgaoRequest $request)
    {
        return $this->interactor->createOrgao(new InputRequestOrgao($request->all()));
    }

    public function update(UpdateOrgaoRequest $request)
    {
        return $this->interactor->updateOrgao(new InputRequestOrgao($request->all()));
    }

    public function readByDocument(string $documento)
    {
        return $this->interactor->getOrgaoPorDocumento(new InputRequestOrgao(['cnpj' => $documento]));
    }

    public function readById(int $codigo)
    {
        return $this->interactor->getOrgaoPorCodigo(new InputRequestOrgao(['codigo' => $codigo]));
    }

    public function readAll(Request $request)
    {
        $filtro = $request->all();

        if (isset($filtro['pagina']) && $filtro['pagina'] === null) {
            $filtro['pagina'] = 1;
        }

        return $this->interactor->getOrgaos($filtro);
    }
}
