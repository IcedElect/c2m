<?php

namespace App\Bot\Messages;

use App\Bot\Keyboards\StartKeyboard;

class RequestContactMessage extends BaseMessage
{
    /**
     * @var BaseKeyboard
     */
    protected $replyMarkupClass = StartKeyboard::class;

    /**
     * @return string
     */
    protected function text(): string
    {
        return 'Привет! Этот бот поможет Вам в поиске работы. Для помощи Вам в поиске реботодателя нем необходимы Ваши контактные данные. Пожалуйста предоставьте их нам нажав на кнопку. Передавая контактные данные, вы соглашаеть на обработку нами Ваших персональных данных.';
    }
}
