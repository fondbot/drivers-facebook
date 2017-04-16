<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Contents;

use FondBot\Drivers\Commands\SendAttachment;
use FondBot\Drivers\Facebook\ContentInterface;

class Attachment implements ContentInterface
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