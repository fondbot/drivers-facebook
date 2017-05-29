<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates\ReceiptTemplate;

use FondBot\Contracts\Template;
use FondBot\Contracts\Arrayable;

class Element implements Template, Arrayable
{
    private $title;
    private $subtitle;
    private $quantity;
    private $price = 0;
    private $currency;
    private $imageUrl;

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'ReceiptElement';
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
     * Set quantity.
     *
     * @param int $quantity
     *
     * @return Element
     */
    public function setQuantity(int $quantity): Element
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Set price.
     *
     * @param float $price
     *
     * @return Element
     */
    public function setPrice(float $price): Element
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Set currency.
     *
     * @param string $currency
     *
     * @return Element
     */
    public function setCurrency(string $currency): Element
    {
        $this->currency = $currency;

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
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'currency' => $this->currency,
            'image_url' => $this->imageUrl,
        ];
    }
}
