<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Messages;

use FondBot\Drivers\Commands\SendMessage;
use FondBot\Conversation\Templates\Keyboard;
use FondBot\Drivers\Exceptions\InvalidArgument;
use FondBot\Conversation\Templates\Keyboard\UrlButton;
use FondBot\Conversation\Templates\Keyboard\ReplyButton;
use FondBot\Conversation\Templates\Keyboard\PayloadButton;
use FondBot\Drivers\Facebook\Messages\Keyboard\Buttons\CallButton;

class TemplatedMessage implements Content
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
            'message' => [
                'attachment' => [
                    'type' => 'template',
                    'payload' => [
                        'template_type' => 'button',
                        'text' => $this->command->text,
                        'buttons' => $this->compileButtons(),
                    ],
                ],
            ],
        ];
    }

    public function encodeType(): string
    {
        return 'json';
    }

    private function compileButtons(): array
    {
        /** @var Keyboard $keyboard */
        $keyboard = $this->command->template;

        $buttons = [];

        foreach ($keyboard->getButtons() as $button) {
            $payload = [
                'title' => $button->getLabel(),
            ];

            if ($button instanceof UrlButton) {
                $payload = array_merge(
                    $payload,
                    ['type' => 'web_url', 'url' => $button->getUrl()],
                    $button->getParameters()
                );
            } elseif ($button instanceof PayloadButton) {
                $payload = array_merge(
                    $payload,
                    ['type' => 'postback', 'payload' => $button->getPayload()]
                );
            } elseif ($button instanceof ReplyButton) {
                throw new InvalidArgument('Use PayloadButton instead of ReplyButton');
            } elseif ($button instanceof CallButton) {
                $payload = array_merge(
                    $payload,
                    ['type' => 'phone_number', 'payload' => $button->getPhone()]
                );
            }

            $buttons[] = $payload;
        }

        return $buttons;
    }
}
