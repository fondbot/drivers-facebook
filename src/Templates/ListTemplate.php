<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates;

use FondBot\Contracts\Template;
use FondBot\Contracts\Arrayable;
use FondBot\Templates\Keyboard\Button;
use FondBot\Drivers\Facebook\Templates\ListTemplate\Element;

class ListTemplate implements Template, Arrayable
{
    public const STYLE_LARGE = 'large';
    public const STYLE_COMPACT = 'compact';

    private $sharable = false;
    private $topElementStyle = self::STYLE_COMPACT;
    private $elements = [];
    private $buttons = [];

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'List';
    }

    /**
     * Set sharable.
     *
     * @param bool $sharable
     *
     * @return ListTemplate
     */
    public function setSharable(bool $sharable): ListTemplate
    {
        $this->sharable = $sharable;

        return $this;
    }

    /**
     * Set top element style.
     *
     * @param string $topElementStyle
     *
     * @return ListTemplate
     */
    public function setTopElementStyle(string $topElementStyle): ListTemplate
    {
        $this->topElementStyle = $topElementStyle;

        return $this;
    }

    /**
     * Add element.
     *
     * @param Element $element
     *
     * @return ListTemplate
     */
    public function addElement(Element $element): ListTemplate
    {
        $this->elements[] = $element;

        return $this;
    }

    /**
     * Add button.
     *
     * @param Button $button
     *
     * @return ListTemplate
     */
    public function addButton(Button $button): ListTemplate
    {
        $this->buttons = $button;

        return $this;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'attachment' => [
                'type' => 'template',
                'payload' => [
                    'template_type' => 'list',
                    'sharable' => $this->sharable,
                    'top_element_style' => $this->topElementStyle,
                    'elements' => $this->elements,
                    'buttons' => $this->buttons,
                ],
            ],
        ];
    }
}
