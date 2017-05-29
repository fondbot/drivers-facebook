<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates\Buttons;

use FondBot\Contracts\Arrayable;
use FondBot\Templates\Keyboard\Button;

/**
 * @see https://developers.facebook.com/docs/messenger-platform/account-linking/unlink-account
 */
class LogOutButton extends Button implements Arrayable
{
    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'LogOutButton';
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type' => 'account_unlink',
        ];
    }
}
