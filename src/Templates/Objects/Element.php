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

    public function __construct(string $title, float $price = 0)
    {
        $this->title = $title;
        $this->price = $price;
    }

    public static function create(string $title, float $price = 0): Element
    {
        return new static($title, $price);
    }

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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): Element
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): Element
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): Element
    {
        $this->currency = $currency;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): Element
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }
}