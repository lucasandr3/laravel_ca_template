<?php

namespace App\Models\Arquivo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArquivoCompra extends Model
{
    use HasFactory;

    protected $table = 'compra_has_arquivo';

    public $timestamps = false;

    protected $fillable = array(
        'dat_envio', 'cod_compra', 'cod_edital', 'cod_pregao', 'caminho', 'sequencial', 'location_pncp', 'sequencial_documento',
        'bol_excluido', 'motivo'
    );
}
