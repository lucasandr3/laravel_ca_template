<?php

namespace App\Infra\Database\Repositories\External\Arquivo;

use App\Models\External\EditalDocument;
use App\Models\External\Process;
use App\Shared\Interfaces\GetExternalDocument;

class ExternalDocument implements GetExternalDocument
{
    public function getEditalDocument(int $codDocument)
    {
        return EditalDocument::query()->where('id', $codDocument)->first();
    }
}
