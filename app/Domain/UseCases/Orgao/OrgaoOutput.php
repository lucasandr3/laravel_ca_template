<?php

namespace App\Domain\UseCases\Orgao;

use App\Domain\Interfaces\PregaoEletronico\ViewModel;
use App\Domain\UseCases\PregaoEletronico\CreateProcessResponseModel;

interface OrgaoOutput
{
    public function allOrgans(string $organs);

    public function organ(string $organ);

    public function notFoundResource(string $result);

    public function unableCreate(string $result);

    public function unableUpdated(string $result);
}
