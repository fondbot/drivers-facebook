<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates\Objects;

use FondBot\Drivers\Facebook\Templates\AbstractTemplate;

class Address extends AbstractTemplate
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

    public function transform(): array
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

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street)
    {
        $this->street = $street;
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

    public function setCity(string $city)
    {
        $this->city = $city;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode)
    {
        $this->postalCode = $postalCode;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state)
    {
        $this->state = $state;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country)
    {
        $this->country = $country;
    }
}