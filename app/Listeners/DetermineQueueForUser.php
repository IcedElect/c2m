<?php

namespace App\Listeners;

use App\Events\User\UserCreating;
use App\Models\Queue;
use App\Services\QueueService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DetermineQueueForUser
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
     * @param  \App\Events\User\UserCreating  $event
     * @return void
     */
    public function handle(UserCreating $event)
    {
        $queue = $this->service->getActive();
        if ($queue instanceof Queue) {
            $event->user->queue_id = $queue->id;
        }
    }
}
