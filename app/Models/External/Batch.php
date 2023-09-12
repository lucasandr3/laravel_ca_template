<?php

namespace App\Models\External;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $connection = 'backend_v2';
    protected $table = 'lote';

    public function status(): Status
    {
        return $this->belongsTo(Status::class, "cod_status")->getResults();
    }
}
