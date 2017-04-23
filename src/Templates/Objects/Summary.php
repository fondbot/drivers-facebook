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

    public function __construct(float $totalCost)
    {
        $this->totalCost = $totalCost;
    }

    public static function create(float $totalCost): Summary
    {
        return new static($totalCost);
    }

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

    public function getSubtotal(): ?float
    {
        return $this->subtotal;
    }

    public function setSubtotal(float $subtotal)
    {
        $this->subtotal = $subtotal;
    }

    public function getShippingCost(): ?float
    {
        return $this->shippingCost;
    }

    public function setShippingCost(float $shippingCost)
    {
        $this->shippingCost = $shippingCost;
    }

    public function getTotalTax(): ?float
    {
        return $this->totalTax;
    }

    public function setTotalTax(float $totalTax)
    {
        $this->totalTax = $totalTax;
    }

    public function getTotalCost(): float
    {
        return $this->totalCost;
    }
}