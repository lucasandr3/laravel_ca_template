<?php

namespace App\Models\PregaoEletronico;

use App\Models\External\Administration;
use App\Models\External\Notice;
use App\Models\External\ProcessSupportLegal;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Compra extends Model
{
    use HasFactory;

    protected $table = 'compra';

    public $timestamps = false;

    protected $casts = [
        'dat_publicacao_pncp' => 'date:Y-m-d H:i:s',
        'dat_ini_proposta' => 'date:Y-m-d H:i:s',
        'dat_fim_proposta' => 'date:Y-m-d H:i:s'
    ];

    protected $fillable = array(
        'cod_pregao', 'objeto', 'processo', 'numero', 'ano', 'sequencial', 'cnpj_entidade', 'cod_unidade', 'srp',
        'amparo', 'num_controle_pncp', 'cod_situacao', 'cod_tipo_instrumento', 'cod_disputa', 'cod_modalidade',
        'usuario', 'total_estimado', 'total_homologado', 'dat_publicacao_pncp', 'dat_ini_proposta', 'dat_fim_proposta',
        'dat_inclusao', 'dat_atualizacao', 'response_pncp',
        'compra_uri', 'documento_uri', 'updated_at'
    );
}
