<?php

declare(strict_types=1);

namespace Tests\Classes\Contents;

use Faker\Factory;
use Tests\Classes\Contracts\ContentInterface;

abstract class AbstractContent implements ContentInterface
{
    private $faker;

    protected function faker()
    {
        if ($this->faker === null) {
            $this->faker = Factory::create();
        }

        return $this->faker;
    }
}
