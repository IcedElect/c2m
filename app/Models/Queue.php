<?php

namespace App\Models;

use App\Models\Traits\Queueable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory, Queueable;

    /**
     * @var int
     */
    const SIZE = 10;

    /**
     * @var string[].
     */
    const STATUSES = [
        'created' => 'created',
        'active' => 'active',
        'filled' => 'filled',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'status',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function active() : \Illuminate\Database\Eloquent\Builder
    {
        return self::has('transactions', '<', self::SIZE);
    }
}
