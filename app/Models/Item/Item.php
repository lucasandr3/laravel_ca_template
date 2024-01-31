<?php

namespace App\Models\Item;

use App\Models\External\Batch;
use App\Models\External\Process;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'compra_item';

    public $timestamps = false;

    protected $casts = [
        'dat_envio' => 'date:Y-m-d H:i:s',
        'data_resultado' => 'datetime:Y-m-d H:i:s'
    ];

    protected $fillable = array(
        'dat_envio', 'cod_compra', 'cod_pregao', 'numero_item', 'material_servico', 'tipo_beneficio', 'incentivo_produtivo_basico',
        'descricao', 'quantidade', 'unidade_medida', 'valor_unitario_estimado', 'valor_total', 'situacao_compra_item',
        'criterio_julgamento', 'valor_unitario_homologado', 'valor_total_homologado', 'percentual_desconto', 'data_resultado',
        'sequencial_resultado', 'cod_situacao_item', 'cod_lote'
    );
}
