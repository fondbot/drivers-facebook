<?php

declare(strict_types=1);

namespace Tests\Classes\Contracts;

interface PayloadInterface extends ContentInterface
{
    public function getPayload(): string;
}
