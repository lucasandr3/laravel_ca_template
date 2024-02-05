<?php

namespace App\Models\External;

use Illuminate\Database\Eloquent\Model;

class Framing extends Model
{
    /** @var string */
    protected $table = 'tipo_enquadramento';

    /** @var string */
    protected $connection = 'backend_v2';

    /** @var bool */
    public $timestamps = false;

    /** @var string[] */
    protected $fillable = array(
        'sigla',
        'descricao'
    );
}
