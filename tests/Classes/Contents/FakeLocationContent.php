<?php

declare(strict_types=1);

namespace Tests\Classes\Contents;

class FakeLocationContent extends AbstractContent
{
    private $latitude;
    private $longitude;

    public function __construct(float $latitude = null, float $longitude = null)
    {
        $this->latitude = $latitude ?: $this->faker()->latitude;
        $this->longitude = $longitude ?: $this->faker()->longitude;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function toArray(): array
    {
        return [
            'type' => 'location',
            'payload' => [
                'coordinates' => [
                    'lat' => $this->latitude,
                    'long' => $this->longitude,
                ],
            ],
        ];
    }
}