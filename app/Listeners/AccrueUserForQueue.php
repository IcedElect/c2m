<?php

namespace App\Listeners;

use App\Events\Queue\QueueFilled;
use App\Models\Queue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AccrueUserForQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Queue\QueueFilled  $event
     * @return void
     */
    public function handle(QueueFilled $event)
    {
        $queue = $event->queue;
        $transaction = $event->transaction;

        $queue->user->deposit(5000, ['queue_id' => $queue->id, 'last_transaction_id' => $transaction->id]);
    }
}
