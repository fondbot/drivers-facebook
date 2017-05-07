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

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public static function create(string $url): LogInButton
    {
        return new static($url);
    }

    public function toArray(): array
    {
        return [
            'type' => 'account_link',
            'url' => $this->url,
        ];
    }
}