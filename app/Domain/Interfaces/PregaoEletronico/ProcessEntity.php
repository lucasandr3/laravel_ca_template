<?php

namespace App\Domain\Interfaces\PregaoEletronico;

use Illuminate\Database\Eloquent\Casts\Json;

interface ProcessEntity
{
    public function getCnpj(): string;

    public function setCnpj(string $cnpj): void;

    public function getCodigoUnidadeCompradora(): int;

    public function setCodigoUnidadeCompradora(int $codigoUnidade): void;

    public function getObjetoCompra(): string;

    public function setObjetoCompra(string $objeto): void;

    public function getAnoCompra(): int;

    public function setAnoCompra(int $anoCompra): void;

    public function getSrp(): bool;

    public function setSrp(bool $srp): void;

    public function getNumeroCompra(): string;

    public function setNumeroCompra(string $numeroCompra): void;

    public function getNumeroProcesso(): string;

    public function setNumeroProcesso(string $numeroProcesso): void;

    public function getDataAberturaProposta(): string;

    public function setDataAberturaProposta(string $dataAberturaProposta): void;

    public function getDataEncerramentoProposta(): string;

    public function setDataEncerramentoProposta(string $dataEncerramentoProposta): void;

    public function getTipoInstrumentoConvocatorioId(): int;

    public function setTipoInstrumentoConvocatorioId(int $tipoInstrumento): void;

    public function getModalidadeId(): int;

    public function setModalidadeId(int $modalidade): void;

    public function getModoDisputaId(): int;

    public function setModoDisputaId(int $modoDisputa): void;

    public function getSituacaoCompraId(): int;

    public function setSituacaoCompraId(int $situacaoCompra): void;

    public function getInformacaoComplementar(): string;

    public function setInformacaoComplementar(string $informacaoComplementar): void;

    public function getAmparoLegalId(): int;

    public function setAmparoLegalId(int $amparoLegal): void;

    public function getLinkSistemaOrigem();

    public function setLinkSistemaOrigem(string $location): void;

    public function getItensCompra(): array;

    public function setItensCompra(array $itens): void;

    public function toJson(): string;

    public function toArray(): array;
}
