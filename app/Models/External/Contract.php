<?php

namespace App\Models\External;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    /** @var string */
    protected $table = 'compra_contrato';

    /** @var bool */
    public $timestamps = false;

    /** @var string[] */
    protected $fillable = [
        'cod_pregao', 'cod_fornecedor','cnpj_entidade','ano_compra','sequencial_compra','sequencial_contrato','tipo_contrato',
        'numero_contrato','ano_contrato','numero_processo','categoria_processo','bol_receita',
        'cod_unidade','doc_fornecedor','natureza_fornecedor','razao_social_fornecedor',
        'doc_fornecedor_subcontratado','natureza_fornecedor_sub','razao_social_fornecedor_sub',
        'objeto_contrato','info_complementar','valor_inicial','numero_parcelas','valor_parcela',
        'valor_global','valor_acumulado','dat_assinatura','dat_inicio_vigencia','dat_termino_vigencia',
        'identificador_cipi', 'url_cipi', 'location_api_result', 'location'
    ];
}
