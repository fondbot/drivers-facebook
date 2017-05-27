<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates\Buttons;

/**
 * Class LogOutButton
 *
 * @see https://developers.facebook.com/docs/messenger-platform/account-linking/unlink-account
 *
 * @package FondBot\Drivers\Facebook\Templates\Buttons
 */
class LogOutButton implements Button
{
    public function toArray(): array
    {
        return [
            'type' => 'account_unlink',
        ];
    }
}