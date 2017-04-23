<?php

declare(strict_types=1);

namespace Tests\Classes;

use FondBot\Helpers\Str;

class FakeMessage
{
    private $senderId;
    private $text;

    public function __construct(string $senderId = null, string $text = null)
    {
        $this->senderId = $senderId ?: Str::random();
        $this->text = $text ?: Str::random();
    }

    /**
     * @return string
     */
    public function getSenderId(): string
    {
        return $this->senderId;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    public function toArray(): array
    {
        return [
            'entry' => [
                [
                    'messaging' => [
                        [
                            'sender' => ['id' => $this->getSenderId()],
                            'message' => ['text' => $this->getText()],
                        ],
                    ],
                ],
            ],
        ];
    }
}
