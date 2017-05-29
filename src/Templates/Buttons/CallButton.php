<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates\Buttons;

use FondBot\Contracts\Arrayable;
use FondBot\Templates\Keyboard\Button;

/**
 * @see https://developers.facebook.com/docs/messenger-platform/send-api-reference/call-button
 */
class CallButton extends Button implements Arrayable
{
    private $phone;

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'CallButton';
    }

    /**
     * Set phone.
     *
     * @param string $phone
     *
     * @return CallButton
     */
    public function setPhone(string $phone): CallButton
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type' => 'phone_number',
            'title' => $this->label,
            'payload' => $this->phone,
        ];
    }
}
