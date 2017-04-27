<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Messages;

use FondBot\Contracts\Arrayable;
use FondBot\Drivers\Facebook\Messages\Objects\QuickReplies;

class QuickReplyMessage implements Arrayable
{
    private $text;
    private $replies;

    public function __construct(string $text, QuickReplies $replies)
    {
        $this->text = $text;
        $this->replies = $replies->toArray();
    }

    public static function create(string $text, QuickReplies $replies): QuickReplyMessage
    {
        return new static($text, $replies);
    }

    public function toArray(): array
    {
        return [
            'text' => $this->text,
            'quick_replies' => $this->replies,
        ];
    }
}