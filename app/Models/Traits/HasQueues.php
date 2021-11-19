<?php

namespace App\Models\Traits;

use App\Models\Queue;

trait HasQueues
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function queues() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Queue::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function queue() : \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Queue::class)->ofMany([
            'id' => 'min',
        ], function ($query) {
            $query->where('status', '!=', Queue::STATUSES['filled']);
        });
    }

    /**
     * @return Queue
     */
    public function getQueue() : Queue
    {
        return $this->queues()->first()->loadCount(['transactions']);
    }

    /**
     * @return Queue
     */
    public function createQueue() : Queue
    {
        $queue = new Queue();
        $queue->fill([
            'user_id' => $this->id,
        ]);
        $queue->save();

        return $queue;
    }

    /**
     * @return int
     */
    public function getPosition() : int
    {
        $queue = $this->queue;

        if ($queue instanceof Queue) {
            $queue->loadCount(['transactions']);
            $before = Queue::active()->where('id', '<', $queue->id)->withCount(['transactions']);
            $beforeSum = $before->get()->sum('transactions_count');
            $beforeCount = $before->count();
            $beforeLeft = Queue::SIZE * $beforeCount - $beforeSum;
            $left = Queue::SIZE - $queue->transactions_count;

            return $beforeLeft + $left;
        }

        return 0;
    }
}
