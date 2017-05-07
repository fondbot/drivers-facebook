<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates\Buttons;

/**
 * Class PostBackButton
 *
 * @see https://developers.facebook.com/docs/messenger-platform/send-api-reference/postback-button
 *
 * @package FondBot\Drivers\Facebook\Templates\Buttons
 */
class PostBackButton implements Button
{
    private $title;
    private $payload;

    public function __construct(string $title, string $payload)
    {
        $this->title = $title;
        $this->payload = $payload;
    }

    public static function create(string $title, string $payload): PostBackButton
    {
        return new static($title, $payload);
    }

    public function toArray(): array
    {
        return [
            'type' => 'postback',
            'title' => $this->title,
            'payload' => $this->payload,
        ];
    }
}