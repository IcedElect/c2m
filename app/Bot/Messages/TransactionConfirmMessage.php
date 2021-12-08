<?php

namespace App\Bot\Messages;

use App\Bot\Keyboards\MainKeyboard;
use App\Bot\Keyboards\PayKeyboard;
use App\Models\User;

class QueueJoinMessage extends BaseMessage
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
        $user = resolve(User::class);
        $position = $user->getPosition();

        return "Оплата успешно прошла. Ваша позиция в очереди {$position}.";
    }
}
