<?php

namespace App\Models\Traits;

use App\Models\Queue;
use App\Models\Transaction;

trait Queueable
{
    /**
     * @return bool
     */
    public function isFilled() : bool
    {
        return $this->transactions()->where('status', Transaction::STATUSES['confirmed'])->count() >= Queue::SIZE;
    }
}
