<?php

namespace App\Adapters\ViewModels;

use App\Domain\Interfaces\Pregao\ViewModel;
use Illuminate\Http\Resources\Json\JsonResource;

class JsonResourceModel implements ViewModel
{
    private JsonResource $resource;

    public function __construct(JsonResource $resource)
    {
        $this->resource = $resource;
    }

    public function getResource(): JsonResource
    {
        return $this->resource;
    }
}
