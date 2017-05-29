<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates\Buttons;

use FondBot\Contracts\Arrayable;
use FondBot\Templates\Keyboard\Button;

/**
 * @see https://developers.facebook.com/docs/messenger-platform/account-linking
 */
class LogInButton extends Button implements Arrayable
{
    private $url;

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'LogInButton';
    }

    /**
     * Set URL.
     *
     * @param string $url
     *
     * @return LogInButton
     */
    public function setUrl(string $url): LogInButton
    {
        $this->url = $url;

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
            'type' => 'account_link',
            'url' => $this->url,
        ];
    }
}
