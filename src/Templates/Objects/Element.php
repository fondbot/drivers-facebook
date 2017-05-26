<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates\Objects;

use FondBot\Contracts\Arrayable;
use JsonSerializable;

class Element implements Arrayable, JsonSerializable
{
    private $title;
    private $subtitle;
    private $quantity;
    private $price;
    private $currency;
    private $imageUrl;

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'currency' => $this->currency,
            'image_url' => $this->imageUrl,
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function setSubtitle(string $subtitle): Element
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function setQuantity(int $quantity): Element
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function setCurrency(string $currency): Element
    {
        $this->currency = $currency;

        return $this;
    }

    public function setImageUrl(string $imageUrl): Element
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function setTitle(string $title): Element
    {
        $this->title = $title;

        return $this;
    }

    public function setPrice(float $price): Element
    {
        $this->price = $price;

        return $this;
    }
}
