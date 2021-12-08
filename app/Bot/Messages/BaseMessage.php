<?php

namespace App\Bot\Messages;

use App\Bot\Keyboards\BaseKeyboard;

abstract class BaseMessage
{
    /**
     * @var string|null
     */
    protected $text = null;

    /**
     * @var string|null
     */
    protected $replyMarkup = null;

    /**
     * @var BaseKeyboard|null
     */
    protected $replyMarkupClass = null;

    /**
     * @return string|null
     */
    protected function text(): ?string
    {
        return $this->text;
    }

    /**
     * @return string|null
     */
    protected function replyMarkup(): ?string
    {
        if ($this->replyMarkupClass) {
            return (new $this->replyMarkupClass)->markup();
        }

        return $this->replyMarkup;
    }

    /**
     * @return array
     */
    public function get($chat_id = null): array
    {
        return array_merge([
            'text' => $this->text(),
            'reply_markup' => $this->replyMarkup(),
            'inline_markup' => $this->replyMarkup(),
        ], $chat_id ? ['chat_id' => $chat_id] : []);
    }
}
