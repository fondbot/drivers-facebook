<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook;

use FondBot\Conversation\Buttons\Button;
use FondBot\Conversation\Buttons\UrlButton;
use FondBot\Drivers\Command;
use FondBot\Drivers\Commands\SendAttachment;
use FondBot\Drivers\Commands\SendMessage;
use FondBot\Drivers\Exceptions\InvalidConfiguration;
use FondBot\Drivers\Facebook\Contents\Attachment;
use FondBot\Drivers\Facebook\Contents\Message;
use FondBot\Drivers\Facebook\Contents\Template;

class ContentResolver
{
    public static function resolve(Command $command): ContentInterface
    {
        if ($command instanceof SendAttachment) {
            return new Attachment($command);
        } elseif ($command instanceof SendMessage) {
            return self::hasCustomButtons($command) ? new Template($command) : new Message($command);
        }

        throw new InvalidConfiguration('Not resolved command instance.');
    }

    private static function hasCustomButtons(SendMessage $command): bool
    {
        if ($command->keyboard === null) {
            return false;
        }

        return !!collect($command->keyboard->getButtons())->first(function (Button $button) {
            return $button instanceof UrlButton;
        });
    }
}