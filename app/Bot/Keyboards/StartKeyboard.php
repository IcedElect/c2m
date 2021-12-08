<?php

namespace App\Bot\Keyboards;

class StartKeyboard extends BaseKeyboard
{
    /**
     * @return array[]
     */
    protected function keyboard(): array
    {
        return [
            [
                ['text' => 'Отправить контакты', 'request_contact' => true],
            ],
        ];
    }
}
