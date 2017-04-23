<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Commands;

use FondBot\Drivers\Commands\SendAttachment;
use FondBot\Drivers\Facebook\Messages\Content;

class SendAttachmentAdapter implements Content
{
    private $command;

    public function __construct(SendAttachment $command)
    {
        $this->command = $command;
    }

    public function toArray(): array
    {
        return [
            [
                'name' => 'recipient',
                'contents' => json_encode([
                    'id' => $this->command->chat->getId(),
                ]),
            ],
            [
                'name' => 'message',
                'contents' => json_encode([
                    'attachment' => [
                        'type' => $this->command->attachment->getType(),
                        'payload' => [],
                    ],
                ]),
            ],
            [
                'name' => 'filedata',
                'contents' => fopen($this->command->attachment->getPath(), 'rb'),
            ],
        ];
    }

    public function encodeType(): string
    {
        return 'multipart';
    }
}
