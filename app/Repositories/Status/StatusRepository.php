<?php

namespace App\Repositories\Status;

use App\Application\Models\Bid;
use App\Models\External\Status;
use App\Models\Item\Item;
use App\Shared\Interfaces\GetDataStatus;

class StatusRepository implements GetDataStatus
{
    public function getStatusById(int $codStatus)
    {
        return Status::query()->where('id', '=', $codStatus)->first();
    }
}
