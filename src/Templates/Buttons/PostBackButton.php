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

    public function toArray(): array
    {
        return [
            'type' => 'postback',
            'title' => $this->title,
            'payload' => $this->payload,
        ];
    }

    public function setTitle(string $title): PostBackButton
    {
        $this->title = $title;

        return $this;
    }

    public function setPayload(string $payload): PostBackButton
    {
        $this->payload = $payload;

        return $this;
    }
}