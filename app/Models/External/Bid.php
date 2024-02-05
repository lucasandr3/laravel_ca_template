<?php


namespace App\Models\External;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bid extends Eloquent
{
    /**@var string */
    protected $table = 'lance';

    /** @var string */
    protected $connection = 'backend_v2';

    /** @var bool */
    public $timestamps = false;

    /** @var string[] */
    protected $casts = ['dat_lance' => 'date:Y-m-d H:i:s'];

    /** @var string[] */
    protected $fillable = array(
        'valor',
        'dat_lance',
        'cod_lote',
        'cod_fornecedor',
        'lance'
    );

    /** @return Company */
    public function company(): Company
    {
        return $this->belongsTo(Company::class,"cod_fornecedor")->getResults();
    }
}
