<?php

namespace App\Factories\PregaoEletronico;

use App\Domain\Interfaces\PregaoEletronico\ItemEntity;
use App\Domain\Interfaces\PregaoEletronico\ItemFactory;
use App\Models\PregaoEletronico\Item;
use App\Shared\ValueObjects\MaterialOuServicoValueObject;
use App\Shared\ValueObjects\TipoBeneficioValueObject;
use Illuminate\Database\Eloquent\Collection;


class ItemModelFactory implements ItemFactory
{
    public function make(Collection $attributes = null): ItemEntity
    {
        $newAttributes = [];

        if ($attributes === null) {
            return new Item($newAttributes);
        }

        foreach ($attributes as $key => $attribute) {
            $newAttributes[$key]['numeroItem'] = $attribute->id;

            $materialOuServico = new MaterialOuServicoValueObject($attribute);
            $newAttributes[$key]['materialOuServico'] = $materialOuServico->getValue();

            $tipoBeneficio = new TipoBeneficioValueObject($attribute);
            $newAttributes[$key]['tipoBeneficioId'] = $tipoBeneficio->getValue();

            $newAttributes[$key]['incentivoProdutivoBasico'] = CONFIG_INCENTIVO_FISCAL_NAO;
            $newAttributes[$key]['descricao'] = truncate($attribute->descricao, 1500, 0);

            $quantity = formatValueWithPrecision(CONFIG_MONETARIO_PRECISAO, $attribute->quantidade, '.', '');
            $newAttributes[$key]['quantidade'] = $quantity;

            $newAttributes[$key]['unidadeMedida'] = $attribute->unidade;

            $budgetedValue = formatValueWithPrecision(CONFIG_MONETARIO_PRECISAO, $attribute->valor_orcado, '.', '');
            $newAttributes[$key]['valorUnitarioEstimado'] = $budgetedValue;

            $totalAmountBudgeted = bcmul($budgetedValue, $quantity);
            $newAttributes[$key]['valorTotal'] = $totalAmountBudgeted;

            $newAttributes[$key]['itemCategoriaId'] = returnItemCategoryId($attribute->process());
            $newAttributes[$key]['situacaoCompraItemId'] = getPurchaseItemSituationImp($attribute->batch($attribute->process()->id)->status()->nome);
            $newAttributes[$key]['criterioJulgamentoId'] = getJudgment($attribute->process());
            $newAttributes[$key]['orcamentoSigiloso'] = !$attribute->batch($attribute->process()->id)->bol_mostra_orcado;
            $newAttributes[$key]['codLote'] = $attribute->cod_lote;
        }

        return new Item($newAttributes);
    }
}
