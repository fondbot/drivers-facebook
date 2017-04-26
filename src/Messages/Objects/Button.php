<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Messages\Objects;

use FondBot\Contracts\Arrayable;
use JsonSerializable;

class Button implements Arrayable, JsonSerializable
{

    public function toArray(): array
    {
        return [];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}