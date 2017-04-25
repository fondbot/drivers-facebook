<?php

declare(strict_types=1);

namespace Tests\Unit\Templates\Objects;

use FondBot\Drivers\Facebook\Templates\Objects\Summary;
use Tests\TestCase;

class SummaryTest extends TestCase
{
    public function test_default()
    {
        $summary = Summary::create($totalCost = $this->faker()->randomFloat());

        $this->assertSame($totalCost, $summary->getTotalCost());

        $summary->setTotalTax($totalTax = $this->faker()->randomFloat());
        $summary->setSubtotal($subTotal = $this->faker()->randomFloat());
        $summary->setShippingCost($shippingCost = $this->faker()->randomFloat());

        $this->assertSame($totalTax, $summary->getTotalTax());
        $this->assertSame($subTotal, $summary->getSubtotal());
        $this->assertSame($shippingCost, $summary->getShippingCost());

        $result = [
            'subtotal' => $subTotal,
            'shipping_cost' => $shippingCost,
            'total_tax' => $totalTax,
            'total_cost' => $totalCost,
        ];

        $this->assertSame(json_encode($result), json_encode($summary));
    }
}