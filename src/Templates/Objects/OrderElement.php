<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates\Objects;

use FondBot\Contracts\Arrayable;
use JsonSerializable;

class OrderElement implements Arrayable, JsonSerializable
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

    public function setSubtitle(string $subtitle): OrderElement
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function setQuantity(int $quantity): OrderElement
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function setCurrency(string $currency): OrderElement
    {
        $this->currency = $currency;

        return $this;
    }

    public function setImageUrl(string $imageUrl): OrderElement
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function setTitle(string $title): OrderElement
    {
        $this->title = $title;

        return $this;
    }

    public function setPrice(float $price): OrderElement
    {
        $this->price = $price;

        return $this;
    }
}
