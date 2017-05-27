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

    public function toArray(): array
    {
        return [
            'type' => 'phone_number',
            'title' => $this->title,
            'payload' => $this->phone,
        ];
    }

    public function setTitle(string $title): CallButton
    {
        $this->title = $title;

        return $this;
    }

    public function setPhone(string $phone): CallButton
    {
        $this->phone = $phone;

        return $this;
    }
}