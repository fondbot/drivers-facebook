<?php

declare(strict_types=1);

namespace Tests\Unit\Templates\Objects;

use Tests\TestCase;
use FondBot\Drivers\Facebook\Templates\Objects\Element;

class ElementTest extends TestCase
{
    public function test_default()
    {
        $element = Element::create($title = $this->faker()->sentence, $price = $this->faker()->randomFloat());

        $this->assertSame($title, $element->getTitle());
        $this->assertSame($price, $element->getPrice());

        $element->setCurrency($currency = $this->faker()->currencyCode);
        $element->setImageUrl($url = $this->faker()->url);
        $element->setQuantity($quantity = $this->faker()->numberBetween(1, 20));
        $element->setSubtitle($subTitle = $this->faker()->sentence);

        $this->assertSame($currency, $element->getCurrency());
        $this->assertSame($url, $element->getImageUrl());
        $this->assertSame($quantity, $element->getQuantity());
        $this->assertSame($subTitle, $element->getSubtitle());

        $result = [
            'title' => $title,
            'subtitle' => $subTitle,
            'quantity' => $quantity,
            'price' => $price,
            'currency' => $currency,
            'image_url' => $url,
        ];

        $this->assertSame(json_encode($result), json_encode($element));
    }
}
