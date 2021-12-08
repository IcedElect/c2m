<?php

namespace App\Listeners;

use App\Events\Transaction\TransactionConfirmed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendMessageOnTransactionConfirmed
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
        $transaction = $event->transaction;
    }
}
