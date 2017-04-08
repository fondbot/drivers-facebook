<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook;

use FondBot\Drivers\ReceivedMessage\Attachment;
use FondBot\Drivers\User;

class FacebookOutgoingAttachment
{
    protected $recipient;
    protected $attachment;

    public function __construct(User $recipient, Attachment $attachment)
    {
        $this->recipient = $recipient;
        $this->attachment = $attachment;
    }

    public function toArray(): array
    {
        return [
            [
                'name' => 'recipient',
                'contents' => json_encode([
                    'id' => $this->recipient->getId(),
                ]),
            ],
            [
                'name' => 'message',
                'contents' => json_encode([
                    'attachment' => [
                        'type' => $this->attachment->getType(),
                        'payload' => [],
                    ]
                ]),
            ],
            [
                'name' => 'filedata',
                'contents' => fopen($this->attachment->getPath(), 'rb'),
            ],
        ];
    }
}