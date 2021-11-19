<?php

namespace App\Listeners;

use App\Events\Transaction\TransactionCreating;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AssignTransactionUuid
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\TransactionCreating  $event
     * @return void
     */
    public function handle(TransactionCreating $event)
    {
        $event->transaction->uuid = (string) \Str::uuid();
    }
}
