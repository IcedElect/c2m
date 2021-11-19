<?php

namespace App\Models;

use App\Dto\UserParams;
use App\Events\User\UserCreated;
use App\Events\User\UserCreating;
use App\Events\User\UserSaved;
use App\Events\User\UserSaving;
use App\Models\Traits\HasQueues;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\HasWallet;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements Wallet
{
    use HasApiTokens, HasFactory, Notifiable, HasQueues, HasWallet;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'params' => '{}',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'params' => UserParams::class,
        'email_verified_at' => 'datetime',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => UserSaved::class,
        'saving' => UserSaving::class,
        'created' => UserCreated::class,
        'creating' => UserCreating::class,
    ];

    /**
     * @param string $type
     *
     * @return Transaction
     */
    public function createTransaction(string $type = 'payment') : Transaction
    {
        return Transaction::create([
            'user_id' => $this->id,
            'type' => Transaction::TYPES[$type],
        ]);
    }
}
