<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates\Objects;

use FondBot\Contracts\Arrayable;
use FondBot\Drivers\Facebook\Templates\Buttons\Button;
use FondBot\Drivers\Facebook\Templates\Buttons\UrlButton;

class ListElement implements Arrayable
{
    private $title;
    private $subtitle;
    private $imageUrl;
    private $action;
    private $buttons;

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'image_url' => $this->imageUrl,
            'default_action' => $this->action,
            'buttons' => $this->buttons,
        ];
    }

    public function setSubtitle(string $subtitle): ListElement
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function setImageUrl(string $imageUrl): ListElement
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function setAction(UrlButton $button): ListElement
    {
        $this->action = $button->toArray();

        return $this;
    }

    public function setTitle(string $title): ListElement
    {
        $this->title = $title;

        return $this;
    }

    public function setButtons(array $buttons): ListElement
    {
        $this->buttons = array_map(function (Button $button) {
            return $button->toArray();
        }, $buttons);

        return $this;
    }

    public function addButton(Button $button): ListElement
    {
        $this->buttons[] = $button->toArray();

        return $this;
    }
}