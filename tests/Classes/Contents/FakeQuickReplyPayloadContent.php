<?php

declare(strict_types=1);

namespace Tests\Classes\Contents;

use Tests\Classes\Contracts\PayloadInterface;

class FakeQuickReplyPayloadContent extends AbstractContent implements PayloadInterface
{
    private $payload;

    public function __construct(string $payload = null)
    {
        $this->payload = $payload ?: $this->faker()->word;
    }

    /**
     * @return string
     */
    public function getPayload(): string
    {
        return $this->payload;
    }

    public function toArray(): array
    {
        return [
            'quick_reply' => [
                'payload' => $this->payload,
            ],
        ];
    }
}