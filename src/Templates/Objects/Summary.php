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
}