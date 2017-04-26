<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Messages;

use FondBot\Contracts\Arrayable;
use FondBot\Conversation\Template;
use JsonSerializable;

class QuickReplyMessage implements Template, Arrayable, JsonSerializable
{
    public function __construct(string $text)
    {
    }

    public function toArray(): array
    {
        return [];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}