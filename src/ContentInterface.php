<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook;

use FondBot\Contracts\Arrayable;

interface ContentInterface extends Arrayable
{
    public function encodeType(): string ;
}