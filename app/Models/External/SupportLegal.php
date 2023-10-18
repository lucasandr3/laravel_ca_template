<?php


namespace App\Models\External;


use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class EmployeeCompany
 *
 * @package App\Application\Models
 */
class SupportLegal extends Eloquent
{
    /** @var string */
    protected $table = 'inciso';

    /** @var bool */
    public $timestamps = false;

    /** @var string[] */
    protected $fillable
        = array(
            'dat_cadastro',
            'cod_lei_licitacao',
            'numero',
            'descricao',
            'bol_ativo',
            'cod_pncp'
        );
}
