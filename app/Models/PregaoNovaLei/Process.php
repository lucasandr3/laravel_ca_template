<?php

namespace App\Models\PregaoNovaLei;

use App\Domain\Interfaces\PregaoNovaLei\ProcessEntity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static \App\Models\PregaoNovaLei\Process create(array $attributes = [])
 */
class Process implements ProcessEntity
{
    use HasFactory;

    public function __construct(private $attributes){}

    public function getCnpj(): string
    {
        return $this->attributes['cnpj'] ?? '';
    }

    public function setCnpj(string $cnpj): void
    {
        $this->attributes['cnpj'] = $cnpj;
    }

    public function getCodigoUnidadeCompradora(): int
    {
        return $this->attributes['codigoUnidadeCompradora'];
    }

    public function setCodigoUnidadeCompradora(int $codigoUnidade): void
    {
        $this->attributes['codigoUnidadeCompradora'] = $codigoUnidade;
    }

    public function getObjetoCompra(): string
    {
        return $this->attributes['objetoCompra'] ?? '';
    }

    public function setObjetoCompra(string $objeto): void
    {
        $this->attributes['objetoCompra'] = $objeto;
    }

    public function getAnoCompra(): int
    {
        return $this->attributes['anoCompra'] ?? '';
    }

    public function setAnoCompra(int $anoCompra): void
    {
        $this->attributes['anoCompra'] = $anoCompra;
    }

    public function getSrp(): bool
    {
        return $this->attributes['srp'];
    }

    public function setSrp(bool $srp): void
    {
        $this->attributes['srp'] = $srp;
    }

    public function getNumeroCompra(): string
    {
        return $this->attributes['numeroCompra'];
    }

    public function setNumeroCompra(string $numeroCompra): void
    {
        $this->attributes['numeroCompra'] = $numeroCompra;
    }

    public function getNumeroProcesso(): string
    {
        return $this->attributes['numeroProcesso'];
    }

    public function setNumeroProcesso(string $numeroProcesso): void
    {
        $this->attributes['numeroProcesso'] = $numeroProcesso;
    }

    public function getDataAberturaProposta(): string
    {
        return $this->attributes['dataAberturaProposta'];
    }

    public function setDataAberturaProposta(string $dataAberturaProposta): void
    {
        $this->attributes['dataAberturaProposta'] = $dataAberturaProposta;
    }

    public function getDataEncerramentoProposta(): string
    {
        return $this->attributes['dataEncerramentoProposta'];
    }

    public function setDataEncerramentoProposta(string $dataEncerramentoProposta): void
    {
        $this->attributes['dataEncerramentoProposta'] = $dataEncerramentoProposta;
    }

    public function getTipoInstrumentoConvocatorioId(): int
    {
        return $this->attributes['tipoInstrumentoConvocatorioId'];
    }

    public function setTipoInstrumentoConvocatorioId(int $tipoInstrumento): void
    {
        $this->attributes['tipoInstrumentoConvocatorioId'] = $tipoInstrumento;
    }

    public function getModalidadeId(): int
    {
        return $this->attributes['modalidadeId'];
    }

    public function setModalidadeId(int $modalidade): void
    {
        $this->attributes['modalidadeId'] = $modalidade;
    }

    public function getModoDisputaId(): int
    {
        return $this->attributes['modoDisputaId'];
    }

    public function setModoDisputaId(int $modoDisputa): void
    {
        $this->attributes['modoDisputaId'] = $modoDisputa;
    }

    public function getSituacaoCompraId(): int
    {
        return $this->attributes['situacaoCompraId'];
    }

    public function setSituacaoCompraId(int $situacaoCompra): void
    {
        $this->attributes['situacaoCompraId'] = $situacaoCompra;
    }

    public function getInformacaoComplementar(): string
    {
        return $this->attributes['informacaoComplementar'];
    }

    public function setInformacaoComplementar(string $informacaoComplementar): void
    {
        $this->attributes['informacaoComplementar'] = $informacaoComplementar;
    }

    public function getAmparoLegalId(): int
    {
        return $this->attributes['amparoLegalId'];
    }

    public function setAmparoLegalId(int $amparoLegal): void
    {
        $this->attributes['amparoLegalId'] = $amparoLegal;
    }

    public function getLinkSistemaOrigem(): string
    {
        return $this->attributes['linkSistemaOrigem'];
    }

    public function setLinkSistemaOrigem(string $location): void
    {
        $this->attributes['linkSistemaOrigem'] = $location;
    }

    public function getItensCompra(): array
    {
        return $this->attributes['itemsCompra'] ?? [];
    }

    public function setItensCompra(array $itens): void
    {
        $this->attributes['itemsCompra'] = $itens;
    }

    public function toJson(): string
    {
        return json_encode($this->attributes, JSON_THROW_ON_ERROR);
    }
}
