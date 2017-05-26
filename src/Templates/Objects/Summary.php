<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates\Objects;

use FondBot\Contracts\Arrayable;
use JsonSerializable;

class Summary implements Arrayable, JsonSerializable
{
    private $subtotal;
    private $shippingCost;
    private $totalTax;
    private $totalCost;

    public function toArray(): array
    {
        return [
            'subtotal' => $this->subtotal,
            'shipping_cost' => $this->shippingCost,
            'total_tax' => $this->totalTax,
            'total_cost' => $this->totalCost,
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function setSubtotal(float $subtotal): Summary
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    public function setShippingCost(float $shippingCost): Summary
    {
        $this->shippingCost = $shippingCost;

        return $this;
    }

    public function setTotalTax(float $totalTax): Summary
    {
        $this->totalTax = $totalTax;

        return $this;
    }

    public function setTotalCost(float $totalCost): Summary
    {
        $this->totalCost = $totalCost;

        return $this;
    }
}
