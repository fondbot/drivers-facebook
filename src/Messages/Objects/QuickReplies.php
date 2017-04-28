<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Messages\Objects;

use FondBot\Contracts\Arrayable;

class QuickReplies implements Arrayable
{
    private $items;

    public static function create(): QuickReplies
    {
        return new static;
    }

    public function addButton(string $title, string $payload, string $imageUrl = null): QuickReplies
    {
        $this->items[] = [
            'content_type' => 'text',
            'title' => $title,
            'payload' => $payload,
            'image_url' => $imageUrl,
        ];

        return $this;
    }

    public function addLocation(string $imageUrl = null): QuickReplies
    {
        $this->items[] = [
            'content_type' => 'location',
            'image_url' => $imageUrl,
        ];

        return $this;
    }

    public function toArray(): array
    {
        return $this->items;
    }
}
