<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates\Buttons;

use FondBot\Contracts\Arrayable;
use FondBot\Templates\Keyboard\Button;

/**
 * @see https://developers.facebook.com/docs/messenger-platform/send-api-reference/share-button
 */
class ShareButton extends Button implements Arrayable
{
    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'ShareButton';
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        // TODO implement share_contents parameter
        return [
            'type' => 'element_share',
        ];
    }
}
