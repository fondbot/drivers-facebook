<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates\ReceiptTemplate;

use FondBot\Contracts\Template;
use FondBot\Contracts\Arrayable;

class Address implements Template, Arrayable
{
    private $street1;
    private $street2;
    private $city;
    private $postalCode;
    private $state;
    private $country;

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'ReceiptAddress';
    }

    /**
     * Set street 1.
     *
     * @param string $street1
     *
     * @return Address
     */
    public function setStreet1(string $street1): Address
    {
        $this->street1 = $street1;

        return $this;
    }

    /**
     * Set street 2.
     *
     * @param string $street2
     *
     * @return Address
     */
    public function setStreet2($street2): Address
    {
        $this->street2 = $street2;

        return $this;
    }

    /**
     * Set city.
     *
     * @param string $city
     *
     * @return Address
     */
    public function setCity(string $city): Address
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Set postal code.
     *
     * @param string $postalCode
     *
     * @return Address
     */
    public function setPostalCode(string $postalCode): Address
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Set state.
     *
     * @param string $state
     *
     * @return Address
     */
    public function setState(string $state): Address
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Set country.
     *
     * @param string $country
     *
     * @return Address
     */
    public function setCountry(string $country): Address
    {
        $this->country = $country;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'street_1' => $this->street1,
            'street_2' => $this->street2,
            'city' => $this->city,
            'postal_code' => $this->postalCode,
            'state' => $this->state,
            'country' => $this->country,
        ];
    }
}
