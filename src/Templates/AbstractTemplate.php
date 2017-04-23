<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates;

use FondBot\Drivers\Facebook\TemplateInterface;

abstract class AbstractTemplate implements TemplateInterface
{
    public function toArray(): array
    {
        return array_map(function ($item) {
            return $item instanceof TemplateInterface ? $item->toArray() : $item;
        }, $this->transform());
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}