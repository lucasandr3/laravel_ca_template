<?php

namespace App\Models\External;

use Illuminate\Database\Eloquent\Model as Eloquent;

class ProcessExtractLog extends Eloquent
{
    protected $connection = 'backend_v2';
    protected $table = 'extrato_pregao_log';

    public $timestamps = false;

    protected $casts = ['dat_registro' => 'date:Y-m-d H:i:s'];
}
