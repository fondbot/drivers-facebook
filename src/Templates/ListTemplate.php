<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates;

use FondBot\Contracts\Template;
use FondBot\Drivers\Facebook\Templates\Buttons\Button;
use FondBot\Drivers\Facebook\Templates\Objects\ListElement;

/**
 * Class ListTemplate
 *
 * @see https://developers.facebook.com/docs/messenger-platform/send-api-reference/list-template
 *
 * @package FondBot\Drivers\Facebook\Templates
 */
class ListTemplate implements Template
{
    public const STYLE_LARGE = 'large';
    public const STYLE_COMPACT = 'compact';

    private $sharable;
    private $style = self::STYLE_COMPACT;
    private $elements;
    private $buttons;

    public function toArray(): array
    {
        return [
            'attachment' => [
                'type' => 'template',
                'payload' => [
                    'template_type' => 'list',
                    'sharable' => $this->sharable,
                    'top_element_style' => $this->style,
                    'elements' => $this->elements,
                    'buttons' => $this->buttons,
                ],
            ],
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function addElement(ListElement $element): ListTemplate
    {
        $this->elements[] = $element->toArray();

        return $this;
    }

    public function setElements(array $elements): ListTemplate
    {
        $this->elements = array_map(function (ListElement $element) {
            return $element->toArray();
        }, $elements);

        return $this;
    }

    public function setStyleCompact(): ListTemplate
    {
        $this->style = self::STYLE_COMPACT;

        return $this;
    }

    public function setStyleLarge(): ListTemplate
    {
        $this->style = self::STYLE_LARGE;

        return $this;
    }

    public function setSharable(bool $sharable = true): ListTemplate
    {
        $this->sharable = $sharable;

        return $this;
    }

    public function setButtons(array $buttons): ListTemplate
    {
        $this->buttons = array_map(function (Button $button) {
            return $button->toArray();
        }, $buttons);

        return $this;
    }

    public function addButton(Button $button): ListTemplate
    {
        $this->buttons[] = $button->toArray();

        return $this;
    }
}