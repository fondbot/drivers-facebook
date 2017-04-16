<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Contents\Buttons;

use FondBot\Conversation\Buttons\Button;

class CallButton implements Button
{
    private $label;
    private $phone;

    public function __construct(string $label, string $phone)
    {
        $this->label = $label;
        $this->phone = $phone;
    }

    /**
     * Button label.
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }
}