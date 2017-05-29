<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates\ListTemplate;

use FondBot\Contracts\Template;
use FondBot\Contracts\Arrayable;
use FondBot\Templates\Keyboard\Button;
use FondBot\Templates\Keyboard\UrlButton;

class Element implements Template, Arrayable
{
    /** @var string */
    private $title;

    /** @var string */
    private $subtitle;

    /** @var string */
    private $imageUrl;

    /** @var UrlButton */
    private $defaultAction;

    /** @var Button[] */
    private $buttons;

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'ListElement';
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Element
     */
    public function setTitle(string $title): Element
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set subtitle.
     *
     * @param string $subtitle
     *
     * @return Element
     */
    public function setSubtitle(string $subtitle): Element
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    /**
     * Set image URL.
     *
     * @param string $imageUrl
     *
     * @return Element
     */
    public function setImageUrl(string $imageUrl): Element
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Set default action.
     *
     * @param UrlButton $defaultAction
     *
     * @return Element
     */
    public function setDefaultAction(UrlButton $defaultAction): Element
    {
        $this->defaultAction = $defaultAction;

        return $this;
    }

    /**
     * Add button.
     *
     * @param Button $button
     *
     * @return Element
     */
    public function addButton(Button $button): Element
    {
        $this->buttons = $button;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'image_url' => $this->imageUrl,
            'default_action' => $this->defaultAction,
            'buttons' => $this->buttons,
        ];
    }
}
