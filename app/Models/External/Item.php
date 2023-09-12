<?php

namespace App\Models\External;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $connection = 'backend_v2';
    protected $table = 'item';

    public function batch(int $processId): Batch
    {
        return $this->belongsTo(Batch::class, "cod_lote")->where('cod_pregao', $processId)->getResults();
    }

    /** @return Process */
    public function process(): Process
    {
        return $this->belongsTo(Process::class, 'cod_pregao')->getResults();
    }
}
