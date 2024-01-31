<?php

namespace App\Domain\UseCases\Contrato;

use App\Shared\ValueObjects\CNPJValueObject;
use App\Shared\ValueObjects\DataContratoValueObject;
use App\Shared\ValueObjects\MoneValueObject;
use App\Shared\ValueObjects\ObjetoCompraValueObject;

class InputRequestContrato
{
    /**
     * @param array $attributes
     */
    public function __construct(
        private readonly array $attributes = [],
    ) {}

    public function getAnoCompra(): string
    {
        return $this->attributes['data']['anoCompra'];
    }

    public function getAnoContrato(): string
    {
        return $this->attributes['data']['anoContrato'];
    }

    public function getCategoriaProcessoId(): int
    {
        return $this->attributes['data']['categoriaProcessoId'];
    }

    public function getCnpjCompra(): string
    {
        return (new CNPJValueObject($this->attributes['data']['cnpjCompra']))->getValue();
    }

    public function getCodFornecedor(): int
    {
        return $this->attributes['data']['cod_fornecedor'];
    }

    public function getCodPregao(): int
    {
        return $this->attributes['data']['cod_pregao'];
    }

    public function getCodigoUnidade(): int
    {
        return $this->attributes['data']['codigoUnidade'];
    }

    public function getDataAssinatura(): string
    {
        return new DataContratoValueObject($this->attributes['data']['dataAssinatura']);
    }

    public function getDataVigenciaFim(): string
    {
        return new DataContratoValueObject($this->attributes['data']['dataVigenciaFim']);
    }

    public function getDataVigenciaInicio(): string
    {
        return new DataContratoValueObject($this->attributes['data']['dataVigenciaInicio']);
    }

    public function getInformacaoComplementar(): string
    {
        return $this->attributes['data']['informacaoComplementar'] ?? "";
    }

    public function getNiFornecedor(): string
    {
        return (new CNPJValueObject($this->attributes['data']['niFornecedor']))->getValue();
    }

    public function getNomeRazaoSocialFornecedor(): string
    {
        return $this->attributes['data']['nomeRazaoSocialFornecedor'];
    }

    public function getNumeroContratoEmpenho(): string
    {
        return $this->attributes['data']['numeroContratoEmpenho'];
    }

    public function getNumeroParcelas(): int
    {
        return $this->attributes['data']['numeroParcelas'];
    }

    public function getObjetoContrato(): string
    {
        return new ObjetoCompraValueObject($this->attributes['data']['objetoContrato']);
    }

    public function getProcesso(): string
    {
        return $this->attributes['data']['processo'];
    }

    public function getReceita(): bool
    {
        return $this->attributes['data']['receita'];
    }

    public function getSequencialCompra(): int
    {
        return $this->attributes['data']['sequencialCompra'];
    }

    public function getTipoContratoId(): int
    {
        return $this->attributes['data']['tipoContratoId'];
    }

    public function getTipoPessoaFornecedor(): string
    {
        return $this->attributes['data']['tipoPessoaFornecedor'];
    }

    public function getValorAcumulado(): string
    {
        return (new MoneValueObject($this->attributes['data']['valorAcumulado']))->getValue();
    }

    public function getValorGlobal(): string
    {
        return (new MoneValueObject($this->attributes['data']['valorGlobal']))->getValue();
    }

    public function getValorInicial(): string
    {
        return (new MoneValueObject($this->attributes['data']['valorInicial']))->getValue();
    }

    public function getValorParcela(): string
    {
        return (new MoneValueObject($this->attributes['data']['valorParcela']))->getValue();
    }

    public function getCodProcesso(): int
    {
        return $this->attributes['processo'];
    }

    public function getSequencialContrato(): int
    {
        return $this->attributes['sequencialContrato'];
    }

    public function getJustificativa(): string
    {
        return $this->attributes['justificativa'];
    }

    public function getContrato(): array
    {
        return [
            'anoCompra' => $this->getAnoCompra(),
            'anoContrato' => $this->getAnoContrato(),
            'categoriaProcessoId' => $this->getCategoriaProcessoId(),
            'cnpjCompra' => $this->getCnpjCompra(),
            'codFornecedor' => $this->getCodFornecedor(),
            'codPregao' => $this->getCodPregao(),
            'codigoUnidade' => $this->getCodigoUnidade(),
            'dataAssinatura' => $this->getDataAssinatura(),
            'dataVigenciaFim' => $this->getDataVigenciaFim(),
            'dataVigenciaInicio' => $this->getDataVigenciaInicio(),
            'informacaoComplementar' => $this->getInformacaoComplementar(),
            'niFornecedor' => $this->getNiFornecedor(),
            'nomeRazaoSocialFornecedor' => $this->getNomeRazaoSocialFornecedor(),
            'numeroContratoEmpenho' => $this->getNumeroContratoEmpenho(),
            'numeroParcelas' => $this->getNumeroParcelas(),
            'objetoContrato' => $this->getObjetoContrato(),
            'processo' => $this->getProcesso(),
            'receita' => $this->getReceita(),
            'sequencialCompra' =>  $this->getSequencialCompra(),
            'tipoContratoId' =>  $this->getTipoContratoId(),
            'tipoPessoaFornecedor' =>  $this->getTipoPessoaFornecedor(),
            'valorAcumulado' =>  $this->getValorAcumulado(),
            'valorGlobal' =>  $this->getValorGlobal(),
            'valorInicial' =>  $this->getValorInicial(),
            'valorParcela' =>  $this->getValorParcela()
        ];
    }
}
