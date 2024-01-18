<?php

namespace App\Models\PregaoEletronico;

use App\Domain\Interfaces\PregaoEletronico\ItemEntity;

class Item implements ItemEntity
{
//    use HasFactory;

    public function __construct(private $attributes){}

    public function getNumeroItem(): string
    {
        return $this->attributes['numeroItem'];
    }

    public function setNumeroItem(string $numeroItem): void
    {
        $this->attributes['numeroItem'] = $numeroItem;
    }

    public function getMaterialOuServico(): int
    {
        return $this->attributes['materialOuServico'];
    }

    public function setMaterialOuServico(int $materialOuServico): void
    {
        $this->attributes['materialOuServico'] = $materialOuServico;
    }

    public function getTipoBeneficioId(): string
    {
        return $this->attributes['tipoBeneficioId'];
    }

    public function setTipoBeneficioId(string $tipoBeneficioId): void
    {
        $this->attributes['tipoBeneficioId'] = $tipoBeneficioId;
    }

    public function getIncentivoProdutivoBasico(): int
    {
        return $this->attributes['incentivoProdutivoBasico'];
    }

    public function setIncentivoProdutivoBasico(int $incentivoProdutivoBasico): void
    {
        $this->attributes['incentivoProdutivoBasico'] = $incentivoProdutivoBasico;
    }

    public function getDescricao(): bool
    {
        return $this->attributes['descricao'];
    }

    public function setDescricao(bool $descricao): void
    {
        $this->attributes['descricao'] = $descricao;
    }

    public function getQuantidade(): string
    {
        return $this->attributes['quantidade'];
    }

    public function setQuantidade(string $quantidade): void
    {
        $this->attributes['quantidade'] = $quantidade;
    }

    public function getUnidadeMedida(): string
    {
        return $this->attributes['unidadeMedida'];
    }

    public function setUnidadeMedida(string $unidadeMedida): void
    {
        $this->attributes['unidadeMedida'] = $unidadeMedida;
    }

    public function getValorUnitarioEstimado(): string
    {
        return $this->attributes['valorUnitarioEstimado'];
    }

    public function setValorUnitarioEstimado(string $valorUnitarioEstimado): void
    {
        $this->attributes['valorUnitarioEstimado'] = $valorUnitarioEstimado;
    }

    public function getValorTotal(): string
    {
        return $this->attributes['valorTotal'];
    }

    public function setValorTotal(string $valorTotal): void
    {
        $this->attributes['valorTotal'] = $valorTotal;
    }

    public function getItemCategoriaId(): int
    {
        return $this->attributes['itemCategoriaId'];
    }

    public function setItemCategoriaId(int $itemCategoriaId): void
    {
        $this->attributes['itemCategoriaId'] = $itemCategoriaId;
    }

    public function getSituacaoCompraItemId(): int
    {
        return $this->attributes['situacaoCompraItemId'];
    }

    public function setSituacaoCompraItemId(int $situacaoCompraItemId): void
    {
        $this->attributes['situacaoCompraItemId'] = $situacaoCompraItemId;
    }

    public function getCriterioJulgamentoId(): int
    {
        return $this->attributes['criterioJulgamentoId'];
    }

    public function setCriterioJulgamentoId(int $criterioJulgamentoId): void
    {
        $this->attributes['criterioJulgamentoId'] = $criterioJulgamentoId;
    }

    public function getOrcamentoSigiloso(): int
    {
        return $this->attributes['orcamentoSigiloso'];
    }

    public function setOrcamentoSigiloso(int $orcamentoSigiloso): void
    {
        $this->attributes['orcamentoSigiloso'] = $orcamentoSigiloso;
    }

    public function getCodLote(): string
    {
        return $this->attributes['codLote'];
    }

    public function setCodLote(string $codLote): void
    {
        $this->attributes['codLote'] = $codLote;
    }

    public function toJson(): string
    {
        return $this->attributes['numeroItem'];
    }

    public function toArray(): array
    {
        return [
            'numeroItem' => $this->getNumeroItem(),
            'materialOuServico' => $this->getMaterialOuServico(),
            'tipoBeneficioId' => $this->getTipoBeneficioId(),
            'incentivoProdutivoBasico' => $this->getIncentivoProdutivoBasico(),
            'descricao' => $this->getDescricao(),
            'quantidade' => $this->getQuantidade(),
            'unidadeMedida' => $this->getUnidadeMedida(),
            'valorUnitarioEstimado' => $this->getValorUnitarioEstimado(),
            'valorTotal' => $this->getValorTotal(),
            'itemCategoriaId' => $this->getItemCategoriaId(),
            'situacaoCompraItemId' => $this->getSituacaoCompraItemId(),
            'criterioJulgamentoId' => $this->getCriterioJulgamentoId(),
            'orcamentoSigiloso' => $this->getOrcamentoSigiloso(),
            'codLote' => $this->getCodLote(),
        ];
    }

    public function getItems(): array
    {
        return $this->attributes;
    }
}
