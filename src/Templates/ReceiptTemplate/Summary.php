<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates\ReceiptTemplate;

use FondBot\Contracts\Template;
use FondBot\Contracts\Arrayable;

class Summary implements Template, Arrayable
{
    private $subtotal;
    private $shippingCost;
    private $totalTax;
    private $totalCost;

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'ReceiptSummary';
    }

    /**
     * Set subtotal.
     *
     * @param float $subtotal
     *
     * @return Summary
     */
    public function setSubtotal(float $subtotal): Summary
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    /**
     * Set shipping cost.
     *
     * @param float $shippingCost
     *
     * @return Summary
     */
    public function setShippingCost(float $shippingCost): Summary
    {
        $this->shippingCost = $shippingCost;

        return $this;
    }

    /**
     * Set total tax.
     *
     * @param float $totalTax
     *
     * @return Summary
     */
    public function setTotalTax(float $totalTax): Summary
    {
        $this->totalTax = $totalTax;

        return $this;
    }

    /**
     * Set total cost.
     *
     * @param float $totalCost
     *
     * @return Summary
     */
    public function setTotalCost(float $totalCost): Summary
    {
        $this->totalCost = $totalCost;

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
            'subtotal' => $this->subtotal,
            'shipping_cost' => $this->shippingCost,
            'total_tax' => $this->totalTax,
            'total_cost' => $this->totalCost,
        ];
    }
}
