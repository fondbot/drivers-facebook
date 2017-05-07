<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates\Buttons;

/**
 * Class CallButton
 *
 * @see https://developers.facebook.com/docs/messenger-platform/send-api-reference/call-button
 *
 * @package FondBot\Drivers\Facebook\Templates\Buttons
 */
class CallButton implements Button
{
    private $title;
    private $phone;

    public function __construct(string $title, string $phone)
    {
        $this->title = $title;
        $this->phone = $phone;
    }

    public static function create(string $title, string $phone): CallButton
    {
        return new static($title, $phone);
    }

    public function toArray(): array
    {
        return [
            'type' => 'phone_number',
            'title' => $this->title,
            'payload' => $this->phone,
        ];
    }
}