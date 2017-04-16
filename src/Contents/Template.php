<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Contents;

use FondBot\Conversation\Buttons\PayloadButton;
use FondBot\Conversation\Buttons\ReplyButton;
use FondBot\Conversation\Buttons\UrlButton;
use FondBot\Drivers\Commands\SendMessage;
use FondBot\Drivers\Exceptions\InvalidArgument;
use FondBot\Drivers\Facebook\ContentInterface;
use FondBot\Drivers\Facebook\Contents\Buttons\CallButton;

class Template implements ContentInterface
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
        $buttons = [];

        foreach ($this->command->keyboard->getButtons() as $button) {
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