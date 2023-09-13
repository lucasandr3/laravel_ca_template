<?php

namespace App\Models\External;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $connection = 'backend_v2';
    protected $table = 'edital';
}
