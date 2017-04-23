<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates\Objects;

use FondBot\Contracts\Arrayable;
use JsonSerializable;

class Address implements Arrayable, JsonSerializable
{
    private $street;
    private $secondaryStreet;
    private $city;
    private $postalCode;
    private $state;
    private $country;

    public function __construct(string $street, string $city, string $postalCode, string $state, string $country)
    {
        $this->street = $street;
        $this->city = $city;
        $this->postalCode = $postalCode;
        $this->state = $state;
        $this->country = $country;
    }

    public static function create(
        string $street,
        string $city,
        string $postalCode,
        string $state,
        string $country
    ): Address {
        return new static($street, $city, $postalCode, $state, $country);
    }

    public function toArray(): array
    {
        return [
            'street_1' => $this->street,
            'street_2' => $this->secondaryStreet,
            'city' => $this->city,
            'postal_code' => $this->postalCode,
            'state' => $this->state,
            'country' => $this->country,
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getSecondaryStreet(): ?string
    {
        return $this->secondaryStreet;
    }

    public function setSecondaryStreet(string $secondaryStreet)
    {
        $this->secondaryStreet = $secondaryStreet;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getCountry(): string
    {
        return $this->country;
    }
}