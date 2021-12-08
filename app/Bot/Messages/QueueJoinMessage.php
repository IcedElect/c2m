<?php

namespace App\Bot\Messages;

use App\Bot\Keyboards\MainKeyboard;
use App\Bot\Keyboards\PayKeyboard;

class QueueJoinMessage extends BaseMessage
{
    /**
     * @var BaseKeyboard
     */
    protected $replyMarkupClass = PayKeyboard::class;

    /**
     * @return string
     */
    protected function text(): string
    {
        return 'Для вступления в очередь вам необходимо оплатить комиссионные услуги (текст нужно придумать).';
    }
}
