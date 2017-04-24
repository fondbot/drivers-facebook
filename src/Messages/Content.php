<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Messages;

use FondBot\Contracts\Arrayable;

interface Content extends Arrayable
{
    public function encodeType(): string;
}
