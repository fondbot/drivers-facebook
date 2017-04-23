<?php

declare(strict_types=1);

namespace Tests\Unit\Templates\Objects;

use FondBot\Drivers\Facebook\Templates\Objects\Adjustment;
use Tests\TestCase;

class AdjustmentTest extends TestCase
{
    public function test_default()
    {
        $result = [
            'name' => null,
            'amount' => null,
        ];

        $adjustment = Adjustment::create();

        $this->assertNull($adjustment->getAmount());
        $this->assertNull($adjustment->getName());
        $this->assertSame(json_encode($result), json_encode($adjustment));

        $adjustment->setAmount($amount = $this->faker()->randomFloat());
        $adjustment->setName($name = $this->faker()->word);

        $this->assertSame($amount, $adjustment->getAmount());
        $this->assertSame($name, $adjustment->getName());
        $this->assertSame(json_encode(compact('name', 'amount')), json_encode($adjustment));
    }
}