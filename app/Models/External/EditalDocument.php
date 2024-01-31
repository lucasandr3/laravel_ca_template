<?php

namespace App\Models\External;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Notice
 * @package App\Application\Models
 */
class EditalDocument extends Model
{
    protected $connection = 'backend_v2';

    protected $table = 'edital';
}
