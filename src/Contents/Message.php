<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Contents;

use FondBot\Conversation\Keyboard;
use FondBot\Drivers\Commands\SendMessage;
use FondBot\Drivers\Facebook\ContentInterface;

class Message implements ContentInterface
{
    private $command;

    public function __construct(SendMessage $command)
    {
        $this->command = $command;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $payload = [
            'recipient' => [
                'id' => $this->command->chat->getId(),
            ],
            'message' => [
                'text' => $this->command->text,
            ],
        ];

        if ($this->command->keyboard instanceof Keyboard) {
            $payload['message']['quick_replies'] = $this->compileKeyboard();
        }

        return $payload;
    }

    public function encodeType(): string
    {
        return 'json';
    }

    private function compileKeyboard(): array
    {
        $payload = [];

        foreach ($this->command->keyboard->getButtons() as $button) {
            $payload[] = [
                'content_type' => 'text',
                'title' => $button->getLabel(),
                'payload' => $button->getLabel(),
            ];
        }

        return $payload;
    }
}