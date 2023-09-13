<?php

namespace App\Models\External;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    use HasFactory;

    protected $connection = 'backend_v2';
    protected $table = 'pregao';

    public function administration(): Administration
    {
        return $this->belongsTo(Administration::class, "cod_comprador")->getResults();
    }

    public function notices(): Collection
    {
        return $this->hasMany(Notice::class, 'cod_pregao')->getResults();
    }
}
