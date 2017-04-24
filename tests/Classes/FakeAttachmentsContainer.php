<?php

declare(strict_types=1);

namespace Tests\Classes;

use Tests\Classes\Contracts\ContentInterface;

class FakeAttachmentsContainer
{
    private $attachments = [];

    public function addAttachment(ContentInterface $attachment)
    {
        $this->attachments[] = $attachment->toArray();
    }

    public function toArray(): array
    {
        return [
            'attachments' => $this->attachments,
        ];
    }
}
