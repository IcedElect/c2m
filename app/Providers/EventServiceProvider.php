<?php

namespace App\Providers;

use App\Events\Queue\QueueFilled;
use App\Events\Transaction\TransactionConfirmed;
use App\Events\Transaction\TransactionCreated;
use App\Events\Transaction\TransactionCreating;
use App\Events\Transaction\TransactionUpdating;
use App\Events\User\UserCreated;
use App\Events\User\UserCreating;
use App\Listeners\AccrueUserForQueue;
use App\Listeners\AssignTransactionUuid;
use App\Listeners\CheckQueueFilled;
use App\Listeners\CheckTransactionConfirmed;
use App\Listeners\CreateUserQueue;
use App\Listeners\DetermineQueueForTransaction;
use App\Listeners\DetermineQueueForUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            // SendEmailVerificationNotification::class,
        ],

        UserCreating::class => [
            // DetermineQueueForUser::class,
        ],
        UserCreated::class => [
            // CreateUserQueue::class,
        ],

        QueueFilled::class => [
            AccrueUserForQueue::class,
        ],

        TransactionCreating::class => [
            AssignTransactionUuid::class,
        ],
        TransactionUpdating::class => [
            DetermineQueueForTransaction::class,
        ],
        TransactionConfirmed::class => [
            CreateUserQueue::class,
            CheckQueueFilled::class,
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
