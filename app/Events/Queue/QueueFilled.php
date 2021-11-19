<?php

namespace App\Events\Queue;

use App\Models\Queue;
use App\Models\Transaction;

class QueueFilled extends QueueEvent
{
    /**
     * @var Transaction
     */
    public $transaction;

    /**
     * @param Queue $queue
     * @param Transaction $transaction
     */
    public function __construct(Queue $queue, Transaction $transaction)
    {
        parent::__construct($queue);
        $this->transaction = $transaction;
    }
}
