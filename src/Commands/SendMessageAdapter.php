<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Commands;

use FondBot\Drivers\Commands\SendMessage;
use FondBot\Conversation\Templates\Keyboard;
use FondBot\Drivers\Facebook\Messages\Content;
use FondBot\Conversation\Templates\Keyboard\Button;
use FondBot\Drivers\Facebook\Messages\BasicMessage;
use FondBot\Conversation\Templates\Keyboard\UrlButton;
use FondBot\Drivers\Facebook\Messages\TemplatedMessage;

class SendMessageAdapter implements Content
{
    private $command;

    /** @var Content */
    private $content;

    public function __construct(SendMessage $command)
    {
        $this->command = $command;
        $this->resolveContent();
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->content->toArray();
    }

    public function encodeType(): string
    {
        return $this->content->encodeType();
    }

    private function resolveContent(): void
    {
        if ($this->hasCustomButtons()) {
            $this->content = new TemplatedMessage($this->command);
        } else {
            $this->content = new BasicMessage($this->command);
        }
    }

    private function hasCustomButtons(): bool
    {
        if (!$this->command->template instanceof Keyboard) {
            return false;
        }

        /** @var Keyboard $keyboard */
        $keyboard = $this->command->template;

        return (bool) collect($keyboard->getButtons())->first(function (Button $button) {
            return $button instanceof UrlButton;
        });
    }
}
