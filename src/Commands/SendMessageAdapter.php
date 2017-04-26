<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Commands;

use FondBot\Conversation\Template;
use FondBot\Conversation\Templates\Keyboard;
use FondBot\Conversation\Templates\Keyboard\Button;
use FondBot\Conversation\Templates\Keyboard\UrlButton;
use FondBot\Drivers\Commands\SendMessage;
use FondBot\Drivers\Facebook\Messages\BasicMessage;
use FondBot\Drivers\Facebook\Messages\Content;
use FondBot\Drivers\Facebook\Messages\TemplatedMessage;
use FondBot\Drivers\Facebook\Templates\TemplateInterface;

class SendMessageAdapter implements Content
{
    private $command;

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
        return [
            'recipient' => [
                'id' => $this->command->chat->getId(),
            ],
            'message' => $this->resolveContent(),
        ];
    }

    public function encodeType(): string
    {
        return 'json';
    }

    private function resolveContent(): array
    {
        if (null === $template = $this->command->template) {
            return (new BasicMessage($this->command))->toArray();
        }

        return $this->compileTemplate($template);
    }

    private function compileTemplate(Template $template): array
    {
        if ($template instanceof TemplateInterface) {
            return $template->toArray();
        }

        if ($template instanceof Keyboard && $this->hasCustomButtons()) {
            return (new TemplatedMessage($this->command))->toArray();
        }

        return (new BasicMessage($this->command))->toArray();
    }


    private function hasCustomButtons(): bool
    {
        /** @var Keyboard $keyboard */
        $keyboard = $this->command->template;

        return (bool) collect($keyboard->getButtons())->first(function (Button $button) {
            return $button instanceof UrlButton;
        });
    }
}
