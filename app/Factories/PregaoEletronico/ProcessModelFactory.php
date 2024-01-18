<?php

namespace App\Factories\PregaoEletronico;

use App\Domain\Interfaces\PregaoEletronico\ProcessEntity;
use App\Domain\Interfaces\PregaoEletronico\ProcessFactory;
use App\Models\PregaoEletronico\Process;
use App\Shared\ValueObjects\AmparoLegalValueObject;
use App\Shared\ValueObjects\DataAberturaPropostaValueObject;
use App\Shared\ValueObjects\DataEncerramentoPropostaValueObject;
use App\Shared\ValueObjects\DisputModeValueObject;
use App\Shared\ValueObjects\InstrumentoConvocatorioValueObject;
use App\Shared\ValueObjects\LinkOrigemValueObject;
use App\Shared\ValueObjects\ModalityValueObject;
use App\Shared\ValueObjects\ObjetoCompraValueObject;
use App\Shared\ValueObjects\SituacaoCompraValueObject;

class ProcessModelFactory implements ProcessFactory
{
    public function make(array $attributes = []): ProcessEntity
    {
        $newAttributes = [];

        $newAttributes['cnpj'] = $attributes['process']->administration()->cnpj;
        $newAttributes['codigoUnidadeCompradora'] = $attributes['process']->administration()->id;
        $newAttributes['anoCompra'] = $attributes['process']->num_ano;
        $newAttributes['srp'] = $attributes['process']->registro_preco === 0;
        $newAttributes['numeroCompra'] = $attributes['process']->numero;
        $newAttributes['numeroProcesso'] = $attributes['process']->processo;
        $newAttributes['informacaoComplementar'] = "";

        if (isset($attributes['process']->descricao)) {
            $newAttributes['objetoCompra'] = new ObjetoCompraValueObject($attributes['process']->descricao);
        }

        if (isset($attributes['process']->dat_publicacao)) {
            $newAttributes['dataAberturaProposta'] = new DataAberturaPropostaValueObject(
                $attributes['process']->dat_publicacao,
                $attributes['process']->tipo_processo
            );
        }

        if (isset($attributes['process']->dat_ini_disputa)) {
            $newAttributes['dataEncerramentoProposta'] = new DataEncerramentoPropostaValueObject(
                $attributes['process']->dat_ini_disputa,
                $attributes['process']->tipo_processo
            );
        }

        if (isset($attributes['process']->tipo_processo)) {
            $newAttributes['tipoInstrumentoConvocatorioId'] = new InstrumentoConvocatorioValueObject(
                $attributes['process']->tipo_processo
            );

            $newAttributes['modalidadeId'] = new ModalityValueObject(
                $attributes['process']->tipo_processo
            );
        }

        if (isset($attributes['process']->tipo_processo, $attributes['process']->tipo_modelo)) {
            $newAttributes['modoDisputaId'] = new DisputModeValueObject(
                $attributes['process']->tipo_processo,
                $attributes['process']->tipo_modelo,
            );
        }

        if (isset($attributes['process'])) {
            $newAttributes['situacaoCompraId'] = new SituacaoCompraValueObject(
                $attributes['process']
            );

            $newAttributes['amparoLegalId'] = new AmparoLegalValueObject(
                $attributes['process']
            );
        }

        if (isset($attributes['parameters'])) {
            $newAttributes['linkSistemaOrigem'] = new LinkOrigemValueObject(
                $attributes['parameters'],
                $attributes['process']->id,
            );
        }

        $newAttributes['itemsCompra'] = (new ItemModelFactory)->make($attributes['items'])->getItems();

        return new Process($newAttributes);
    }
}
