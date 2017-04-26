<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Messages\Objects;

use FondBot\Contracts\Arrayable;

class Location implements Arrayable
{
    private $imageUrl;

    public function toArray(): array
    {
        return [
            'content_type' => 'location',
            'image_url' => $this->getImageUrl(),
        ];
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): Location
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }
}