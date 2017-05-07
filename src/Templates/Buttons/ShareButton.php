<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates\Buttons;

/**
 * Class ShareButton
 *
 * @see https://developers.facebook.com/docs/messenger-platform/send-api-reference/share-button
 *
 * @package FondBot\Drivers\Facebook\Templates\Buttons
 */
class ShareButton implements Button
{
    public static function create(): ShareButton
    {
        return new static;
    }

    public function toArray(): array
    {
        return [
            'type' => 'element_share',
        ];
    }
}