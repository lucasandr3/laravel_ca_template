<?php

namespace App\Adapters\Presenters\Orgao;

use App\Domain\Interfaces\PregaoEletronico\ViewModel;
use App\Domain\UseCases\Orgao\OrgaoOutput;
use App\Domain\UseCases\PregaoEletronico\CreateProcessOutputPort;
use App\Domain\UseCases\PregaoEletronico\CreateProcessResponseModel;
use App\Http\Resources\Orgao\OrgaosResource;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrgaoJsonPresenter implements OrgaoOutput
{
    public function allOrgans(string $organs): JsonResponse
    {
        return response()->json(OrgaosResource::make($this->prepareOutput($organs)));
    }

    public function organ(string $organ): JsonResponse
    {
        return response()->json($this->prepareOutput($organ));
    }

    public function notFoundResource(string $result): JsonResponse
    {
        return response()->json($this->prepareOutput($result));
    }

    public function unableCreate(string $result): JsonResponse
    {
        return response()->json($this->prepareOutput($result));
    }

    public function unableUpdated(string $result)
    {
        return response()->json($this->prepareOutput($result));
    }

    private function prepareOutput(string $output)
    {
        return json_decode($output);
    }
}
