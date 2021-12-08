<?php

namespace App\Bot\Keyboards;

abstract class BaseKeyboard
{
    /**
     * @var bool
     */
    protected $inline = false;

    /**
     * @var bool
     */
    protected $resize_keyboard = true;

    /**
     * @var bool
     */
    protected $one_time_keyboard = false;

    /**
     * @return array[]
     */
    abstract protected function keyboard(): array;

    /**
     * @return string json
     */
    public function markup(): string
    {
        $key = $this->inline ? 'inline_keyboard' : 'keyboard';

        return json_encode([
            $key => $this->keyboard(),
            'resize_keyboard' => $this->resize_keyboard,
            'one_time_keyboard' => $this->one_time_keyboard,
        ]);
    }
}
