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

    public function setSecondaryStreet(string $secondaryStreet): Address
    {
        $this->secondaryStreet = $secondaryStreet;

        return $this;
    }

    public function setStreet(string $street): Address
    {
        $this->street = $street;

        return $this;
    }

    public function setCity(string $city): Address
    {
        $this->city = $city;

        return $this;
    }

    public function setPostalCode(string $postalCode): Address
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function setState(string $state): Address
    {
        $this->state = $state;

        return $this;
    }

    public function setCountry(string $country): Address
    {
        $this->country = $country;

        return $this;
    }
}
