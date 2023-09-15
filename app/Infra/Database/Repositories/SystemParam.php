<?php

namespace App\Infra\Database\Repositories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemParam extends Model
{
    use HasFactory;

    protected $table = 'parametros_sistema';
}
