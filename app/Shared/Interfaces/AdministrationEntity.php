<?php

namespace App\Shared\Interfaces;

use DateTime;

interface AdministrationEntity
{
    public function getId(): int;

    public function getNome(): string;

    public function getCnpj(): string;

    public function getTelefone(): string;

    public function getEmail(): string;

    public function getDatCadastro(): string;

    public function getDatAniversario(): ?DateTime;

    public function getBrasao(): string;

    public function getCidade();

    public function getDecretoPregaoEletronico(): ?string;

    public function getTipo(): ?int;

    public function getCodigoEntidade();

    public function getCodigoMunicipio();

    public function isBolAutorizaPublicacao(): bool;

    public function isRegionalExclusivoMe(): bool;

    public function getPoder(): ?string;

    public function getEsfera(): ?string;

    public function isBolAtivo(): bool;

    public function getTempoMinSessao(): ?DateTime;

    public function toJson();

    public function toArray();
}
