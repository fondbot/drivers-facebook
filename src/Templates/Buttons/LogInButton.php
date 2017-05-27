<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates\Buttons;

/**
 * Class LogInButton
 *
 * @see https://developers.facebook.com/docs/messenger-platform/account-linking/link-account
 *
 * @package FondBot\Drivers\Facebook\Templates\Buttons
 */
class LogInButton implements Button
{
    private $url;

    public function toArray(): array
    {
        return [
            'type' => 'account_link',
            'url' => $this->url,
        ];
    }

    public function setUrl(string $url): LogInButton
    {
        $this->url = $url;

        return $this;
    }
}