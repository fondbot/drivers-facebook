<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Messages;

use FondBot\Drivers\Commands\SendMessage;
use FondBot\Conversation\Templates\Keyboard;

class BasicMessage implements Content
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

        if ($this->command->template instanceof Keyboard) {
            $payload['message']['quick_replies'] = $this->compileQuickReplies();
        }

        return $payload;
    }

    public function encodeType(): string
    {
        return 'json';
    }

    private function compileQuickReplies(): array
    {
        /** @var Keyboard $keyboard */
        $keyboard = $this->command->template;

        $payload = [];

        foreach ($keyboard->getButtons() as $button) {
            $payload[] = [
                'content_type' => 'text',
                'title' => $button->getLabel(),
                'payload' => $button->getLabel(),
            ];
        }

        return $payload;
    }
}
