<?php

namespace App\Listeners;

use App\Events\Transaction\TransactionUpdating;
use App\Models\Queue;
use App\Services\QueueService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DetermineQueueForTransaction
{
    /**
     * @var QueueService
     */
    private $service;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(QueueService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(TransactionUpdating $event)
    {
        if (
            $event->transaction->isDirty('status')
            && $event->transaction->isStatusConfirmed()
        ) {
            $queue = $this->service->getActive();
            if ($queue instanceof Queue) {
                $event->transaction->queue()->associate($queue);
            }
        }
    }
}
