<?php

namespace App\Shared\ValueObjects;

class LinkOrigemValueObject
{
    private array $parameters;
    private int $processId;

    public function __construct(array $parameters, int $processId)
    {
        $this->parameters = $parameters;
        $this->processId = $processId;
    }

    public function getValue(): string
    {
        return sprintf(
            $this->parameters['LINK_SALA_DISPUTA_VISITANTE'],
            base64_encode(encryptParam($this->processId, $this->parameters['KEY_SALA_VISITANTE']))
        );
    }
}
