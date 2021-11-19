<?php

namespace App\Models;

use App\Events\Transaction\TransactionConfirmed;
use App\Events\Transaction\TransactionCreated;
use App\Events\Transaction\TransactionCreating;
use App\Events\Transaction\TransactionRejected;
use App\Events\Transaction\TransactionUpdated;
use App\Events\Transaction\TransactionUpdating;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    const TYPES = [
        'payment' => 'payment',
        'withdraw' => 'withdraw',
    ];

    /**
     * @var string[]
     */
    const STATUSES = [
        'pending' => 'pending',
        'rejected' => 'rejected',
        'confirmed' => 'confirmed',
    ];

    /**
     * @var float
     */
    const DEFAULT_AMOUNT = 1000.00;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'type',
        'status',
        'user_id',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'creating' => TransactionCreating::class,
        'updating' => TransactionUpdating::class,
        'created' => TransactionCreated::class,
        'updated' => TransactionUpdated::class,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function queue() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Queue::class);
    }

    /**
     * Is transaction payment.
     *
     * @return bool
     */
    public function isPayment()
    {
        return $this->type == self::TYPES['payment'];
    }

    /**
     * Is transaction withdraw.
     *
     * @return bool
     */
    public function isWithdraw()
    {
        return $this->type == self::TYPES['withdraw'];
    }

    /**
     * Get transaction by uuid.
     *
     * @param string $uuid
     * @return self|null
     */
    public static function getByUuid(string $uuid)
    {
        return self::whereUuid($uuid)->first();
    }

    /**
     * Get transaction by external id.
     *
     * @param string $externalId
     * @return self|null
     */
    public static function getPaymentByExternalId(string $externalId)
    {
        return self::where('result->externalId', $externalId)
            ->where('type', self::TYPES['payment'])
            ->first();
    }

    /**
     * @param string $status
     *
     * @return self
     */
    public function setStatus(string $status) : self
    {
        $this->status = $status;
        $this->save();

        return $this;
    }

    /**
     * @return self
     */
    public function confirm() : self
    {
        $transaction = $this->setStatus(self::STATUSES['confirmed']);
        TransactionConfirmed::dispatch($transaction);

        return $transaction;
    }

    /**
     * @return self
     */
    public function reject() : self
    {
        $transaction = $this->setStatus(self::STATUSES['rejected']);
        TransactionRejected::dispatch($transaction);

        return $transaction;
    }

    /**
     * Is transaction status pending.
     *
     * @return bool
     */
    public function isStatusPending()
    {
        return $this->status == self::STATUSES['pending'];
    }

    /**
     * @return bool
     */
    public function isStatusConfirmed() : bool
    {
        return $this->status == self::STATUSES['confirmed'];
    }
}
