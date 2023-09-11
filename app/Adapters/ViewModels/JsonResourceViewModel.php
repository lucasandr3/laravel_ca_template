<?php

namespace App\Adapters\ViewModels;

use Illuminate\Http\Resources\Json\JsonResource;

class JsonResourceViewModel
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
