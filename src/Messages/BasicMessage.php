<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Messages;

use FondBot\Contracts\Arrayable;

class BasicMessage implements Arrayable
{
    private $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public static function create(string $text): BasicMessage
    {
        return new static($text);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'text' => $this->text,
        ];
    }
}
