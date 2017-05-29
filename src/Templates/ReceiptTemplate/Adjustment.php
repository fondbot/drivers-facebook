<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates\ReceiptTemplate;

use FondBot\Contracts\Template;
use FondBot\Contracts\Arrayable;

class Adjustment implements Template, Arrayable
{
    private $name;
    private $amount;

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'ReceiptAdjustment';
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Adjustment
     */
    public function setName(string $name): Adjustment
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set amount.
     *
     * @param float $amount
     *
     * @return Adjustment
     */
    public function setAmount(float $amount): Adjustment
    {
        $this->amount = $amount;

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
            'name' => $this->name,
            'amount' => $this->amount,
        ];
    }
}
