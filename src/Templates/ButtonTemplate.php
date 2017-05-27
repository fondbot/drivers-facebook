<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates;

use FondBot\Contracts\Template;
use FondBot\Drivers\Facebook\Templates\Buttons\Button;

class ButtonTemplate implements Template
{
    private $text;
    private $buttons;

    public function toArray(): array
    {
        return [
            'attachment' => [
                'type' => 'template',
                'payload' => [
                    'template_type' => 'button',
                    'text' => $this->text,
                    'buttons' => $this->buttons,
                ],
            ],
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function addButton(Button $button): ButtonTemplate
    {
        $this->buttons[] = $button->toArray();

        return $this;
    }

    public function setButtons(array $buttons): ButtonTemplate
    {
        $this->buttons = array_map(function (Button $button) {
            return $button->toArray();
        }, $buttons);

        return $this;
    }

    public function setText(string $text): ButtonTemplate
    {
        $this->text = $text;

        return $this;
    }
}
