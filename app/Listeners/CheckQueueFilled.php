<?php

namespace App\Listeners;

use App\Events\Queue\QueueFilled;
use App\Events\Transaction\TransactionEvent;
use App\Models\Queue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckQueueFilled
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(TransactionEvent $event)
    {
        $transaction = $event->transaction;
        $queue = $transaction->queue;

        if ($queue instanceof Queue) {
            if ($queue->isFilled()) {
                $queue->status = Queue::STATUSES['filled'];
                $queue->save();

                // TODO: Move dispatch to boot model by updating status
                QueueFilled::dispatch($queue, $transaction);
            }
        }
    }
}
