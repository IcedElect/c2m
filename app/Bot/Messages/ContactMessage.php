<?php

namespace App\Bot\Messages;

use App\Bot\Keyboards\MainKeyboard;

class ContactMessage extends BaseMessage
{
    /**
     * @var BaseKeyboard
     */
    protected $replyMarkupClass = MainKeyboard::class;

    /**
     * @return string
     */
    protected function text(): string
    {
        return 'Спасибо! Теперь вам доступна возможность встать в очередь за поиском работы.';
    }
}
