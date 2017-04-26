<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Messages\Objects;

use FondBot\Contracts\Arrayable;

class QuickReplies implements Arrayable
{
    private $items;

    public function addButton(Button $button): QuickReplies
    {
        $this->items[] = $button->toArray();

        return $this;
    }

    public function addLocation(Location $location): QuickReplies
    {
        $this->items[] = $location->toArray();

        return $this;
    }

    public function toArray(): array
    {
        return $this->items;
    }
}