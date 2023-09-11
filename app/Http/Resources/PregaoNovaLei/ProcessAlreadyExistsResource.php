<?php

namespace App\Http\Resources\PregaoNovaLei;

use App\Domain\Interfaces\PregaoNovaLei\ProcessEntity;
use Illuminate\Http\Resources\Json\JsonResource;

class ProcessAlreadyExistsResource extends JsonResource
{
    protected ProcessEntity $process;

    public function __construct($process)
    {
        parent::__construct($process);
        $this->process = $process;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [

        ];
    }
}
