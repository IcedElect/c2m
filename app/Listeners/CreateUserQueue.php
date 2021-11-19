<?php

namespace App\Listeners;

use App\Events\Transaction\TransactionConfirmed;
use App\Events\User\UserCreated;
use App\Models\Queue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateUserQueue
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
     * @param  \App\Events\Transaction\TransactionConfirmed  $event
     * @return void
     */
    public function handle(TransactionConfirmed $event)
    {
        $user = $event->transaction->user;

        if (! ($user->queue instanceof Queue)) {
            $event->transaction->user->createQueue();
        }
    }
}
