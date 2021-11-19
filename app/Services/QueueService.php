<?php

namespace App\Services;

use App\Models\Queue;
use App\Models\User;

class QueueService
{
    /**
     * @return Queue|null
     */
    public function getActive() : ?Queue
    {
        return Queue::active()->first();
    }
}
