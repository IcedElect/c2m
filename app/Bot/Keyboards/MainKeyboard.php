<?php

namespace App\Bot\Keyboards;

use App\Models\User;

class MainKeyboard extends BaseKeyboard
{
    /**
     * @return array[]
     */
    protected function keyboard(): array
    {
        $user = resolve(User::class);
        $position = $user->getPosition();

        return [
            [
                ['text' => $position ? 'Состояние в очереди' : 'Встать в очередь'],
                ['text' => 'Что за очередь?'],
            ],
            [
                ['text' => 'Об этом боте'],
            ],
            [
                ['text' => 'Стать рекламодателем'],

            ],
        ];
    }
}
