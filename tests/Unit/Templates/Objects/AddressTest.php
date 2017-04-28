<?php

declare(strict_types=1);

namespace Tests\Unit\Templates\Objects;

use Tests\TestCase;
use FondBot\Drivers\Facebook\Templates\Objects\Address;

class AddressTest extends TestCase
{
    public function test_default()
    {
        $result = [
            'street_1' => $street = $this->faker()->streetName,
            'street_2' => null,
            'city' => $city = $this->faker()->city,
            'postal_code' => $postcode = $this->faker()->postcode,
            'state' => $state = $this->faker()->stateAbbr,
            'country' => $country = $this->faker()->countryCode,
        ];

        $address = Address::create($street, $city, $postcode, $state, $country);

        $this->assertSame($street, $address->getStreet());
        $this->assertSame($city, $address->getCity());
        $this->assertSame($postcode, $address->getPostalCode());
        $this->assertSame($state, $address->getState());
        $this->assertSame($country, $address->getCountry());
        $this->assertSame(json_encode($result), json_encode($address));

        $address->setSecondaryStreet($second = $this->faker()->streetName);
        $this->assertSame($second, $address->getSecondaryStreet());

        $result['street_2'] = $second;
        $this->assertSame(json_encode($result), json_encode($address));
    }
}
