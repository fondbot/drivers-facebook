<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates\Objects;

use FondBot\Contracts\Arrayable;
use JsonSerializable;

class Adjustment implements Arrayable, JsonSerializable
{
    private $name;
    private $amount;

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'amount' => $this->amount,
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function setName(string $name): Adjustment
    {
        $this->name = $name;

        return $this;
    }

    public function setAmount(float $amount): Adjustment
    {
        $this->amount = $amount;

        return $this;
    }
}
