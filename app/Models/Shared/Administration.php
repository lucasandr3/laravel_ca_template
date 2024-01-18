<?php

namespace App\Models\Shared;

use App\Shared\Interfaces\AdministrationEntity;
use DateTime;
use Illuminate\Database\Eloquent\Model;

class Administration implements AdministrationEntity
{
    public function __construct(private $attributes){}

    public function getId(): int
    {
        return (int) $this->attributes['id'];
    }

    public function getNome(): string
    {
        return $this->attributes['nome'];
    }

    public function getCnpj(): string
    {
        return $this->attributes['cnpj'];
    }

    public function getTelefone(): string
    {
        return $this->attributes['telefone'];
    }

    public function getEmail(): string
    {
        return $this->attributes['email'];
    }

    public function getDatCadastro(): string
    {
        return $this->attributes['dat_cadastro'];
    }

    public function getDatAniversario(): ?DateTime
    {
        return $this->attributes['dat_aniversario'];
    }

    public function getBrasao(): string
    {
        return $this->attributes['brasao'];
    }

    public function getCidade()
    {
        return $this->attributes['cidade_id'];
    }

    public function getDecretoPregaoEletronico(): ?string
    {
        return $this->attributes['decreto_pregao_eletronico'];
    }

    public function getTipo(): ?int
    {
        return $this->attributes['tipo'];
    }

    public function getCodigoEntidade()
    {
        return $this->attributes['codigo_entidade'];
    }

    public function getCodigoMunicipio()
    {
        return $this->attributes['codigo_municipio'];
    }

    public function isBolAutorizaPublicacao(): bool
    {
        return $this->attributes['bol_autoriza_publicacao'];
    }

    public function isRegionalExclusivoMe(): bool
    {
        return $this->attributes['regional_exclusivo_me'];
    }

    public function getPoder(): ?string
    {
        return $this->attributes['poder'];
    }

    public function getEsfera(): ?string
    {
        return $this->attributes['esfera'];
    }

    public function isBolAtivo(): bool
    {
        return $this->attributes['bol_ativo'] === 1;
    }

    public function getTempoMinSessao(): ?DateTime
    {
        return $this->attributes['tempo_min_sessao'];
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR | $options);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'nome' => $this->getNome(),
            'cnpj' => $this->getCnpj(),
            'telefone' => $this->getTelefone(),
            'email' => $this->getEmail(),
            'dat_cadastro' => $this->getDatCadastro(),
            'dat_aniversario' => $this->getDatAniversario(),
            'brasao' => $this->getBrasao(),
            'cidade_id' => $this->getCidade(),
            'decreto_pregao_eletronico' => $this->getDecretoPregaoEletronico(),
            'tipo' => $this->getTipo(),
            'codigo_entidade' => $this->getCodigoEntidade(),
            'codigo_municipio' => $this->getCodigoMunicipio(),
            'bol_autoriza_publicacao' => $this->isBolAutorizaPublicacao(),
            'regional_exclusivo_me' => $this->isRegionalExclusivoMe(),
            'poder' => $this->getPoder(),
            'esfera' => $this->getEsfera(),
            'bol_ativo' => $this->isBolAtivo(),
            'tempo_min_sessao' => $this->getTempoMinSessao()
        ];
    }
}
