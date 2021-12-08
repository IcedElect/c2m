<?php

namespace App\Bot\Keyboards;

use App\Models\User;

class PayKeyboard extends BaseKeyboard
{
    /**
     * @var bool
     */
    protected $inline = true;

    /**
     * @return array[]
     */
    protected function keyboard(): array
    {
        $user = resolve(User::class);
        $transaction = $user->createTransaction();

        return [
            [
                // ['text' => 'Оплатить', 'url' => route('transaction', ['transaction' => $transaction])],
                ['text' => 'Оплатить '.$transaction->id, 'url' => 'https://google.com'],
            ],
        ];
    }
}
