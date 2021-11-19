<?php

namespace App\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class TransactionResult extends DataTransferObject
{
    /**
     * Transform the attribute from the underlying model values.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return new self(json_decode($value, true));
    }

    /**
     * Transform the attribute to its underlying model values.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        switch (true) {
            case $value instanceof self:
                break;
            case is_array($value):
            default:
                $value = (object) $value;
        }

        return json_encode((object) $value);
    }
}
