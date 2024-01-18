<?php

namespace App\Domain\Interfaces\PregaoEletronico;

use Illuminate\Database\Eloquent\Casts\Json;

interface ItemEntity
{
    public function getNumeroItem(): string;

    public function setNumeroItem(string $numeroItem): void;

    public function getMaterialOuServico(): int;

    public function setMaterialOuServico(int $materialOuServico): void;

    public function getTipoBeneficioId(): string;

    public function setTipoBeneficioId(string $tipoBeneficioId): void;

    public function getIncentivoProdutivoBasico(): int;

    public function setIncentivoProdutivoBasico(int $incentivoProdutivoBasico): void;

    public function getDescricao(): bool;

    public function setDescricao(bool $descricao): void;

    public function getQuantidade(): string;

    public function setQuantidade(string $quantidade): void;

    public function getUnidadeMedida(): string;

    public function setUnidadeMedida(string $unidadeMedida): void;

    public function getValorUnitarioEstimado(): string;

    public function setValorUnitarioEstimado(string $valorUnitarioEstimado): void;

    public function getValorTotal(): string;

    public function setValorTotal(string $valorTotal): void;

    public function getItemCategoriaId(): int;

    public function setItemCategoriaId(int $itemCategoriaId): void;

    public function getSituacaoCompraItemId(): int;

    public function setSituacaoCompraItemId(int $situacaoCompraItemId): void;

    public function getCriterioJulgamentoId(): int;

    public function setCriterioJulgamentoId(int $criterioJulgamentoId): void;

    public function getOrcamentoSigiloso(): int;

    public function setOrcamentoSigiloso(int $orcamentoSigiloso): void;

    public function getCodLote(): string;

    public function setCodLote(string $codLote): void;

    public function toJson(): string;

    public function toArray(): array;

    public function getItems(): array;
}
