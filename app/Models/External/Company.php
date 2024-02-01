<?php

namespace App\Models\External;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $connection = 'backend_v2';

    protected $table = 'fornecedor';

    public $timestamps = false;

    protected $casts = ['dat_cadastro' => 'date:Y-m-d H:i:s'];
}
