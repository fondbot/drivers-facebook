<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Commands;

use FondBot\Templates\Keyboard;
use FondBot\Conversation\Template;
use FondBot\Drivers\Commands\SendMessage;
use FondBot\Drivers\Facebook\Messages\Content;
use FondBot\Drivers\Facebook\Messages\BasicMessage;
use FondBot\Drivers\Exceptions\InvalidConfiguration;
use FondBot\Drivers\Facebook\Templates\ButtonTemplate;
use FondBot\Drivers\Facebook\Messages\QuickReplyMessage;
use FondBot\Drivers\Facebook\Messages\Objects\QuickReplies;
use FondBot\Drivers\Facebook\Messages\Keyboard\Buttons\CallButton;

class SendMessageAdapter implements Content
{
    private $command;

    public function __construct(SendMessage $command)
    {
        $this->command = $command;
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
        if ($this->command->template !== null) {
            return $this->compileTemplate($this->command->template);
        }

        return BasicMessage::create($this->command->text)->toArray();
    }

    private function compileTemplate(Template $template): array
    {
        if ($template instanceof Template) {
            return $template->toArray();
        }

        if ($template instanceof Keyboard) {
            return $this->compileKeyboard($template);
        }

        throw new InvalidConfiguration('Not resolved template instance');
    }

    private function compileKeyboard(Keyboard $keyboard): array
    {
        if ($this->hasCustomButtons($keyboard)) {
            $template = ButtonTemplate::create($this->command->text);

            foreach ($keyboard->getButtons() as $button) {
                if ($button instanceof Keyboard\UrlButton) {
                    $template->addUrlButton($button->getUrl(), $button->getLabel(), $button->getParameters());
                } elseif ($button instanceof Keyboard\PayloadButton) {
                    $template->addPostBackButton($button->getLabel(), $button->getPayload());
                } elseif ($button instanceof CallButton) {
                    $template->addCallButton($button->getLabel(), $button->getPhone());
                } else {
                    $template->addPostBackButton($button->getLabel(), $button->getLabel());
                }
            }

            return $template->toArray();
        }

        $replies = QuickReplies::create();

        foreach ($keyboard->getButtons() as $button) {
            $replies->addButton($button->getLabel(), $button->getLabel());
        }

        return QuickReplyMessage::create($this->command->text, $replies)->toArray();
    }

    private function hasCustomButtons(Keyboard $keyboard): bool
    {
        return (bool) collect($keyboard->getButtons())->first(function (Keyboard\Button $button) {
            return $button instanceof Keyboard\UrlButton;
        });
    }
}
