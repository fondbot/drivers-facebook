<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook;

use FondBot\Drivers\CommandHandler;
use FondBot\Drivers\Commands\SendAttachment;
use FondBot\Drivers\Commands\SendMessage;
use FondBot\Drivers\Commands\SendRequest;

class FacebookCommandHandler extends CommandHandler
{
    /**
     * Handle send message command.
     *
     * @param SendMessage $command
     */
    public function handleSendMessage(SendMessage $command): void
    {
        if ($command->getTemplate() === null) {
            $payload = [
                'text' => $command->getText(),
            ];
        } else {
            $payload = $this->driver
                ->getTemplateCompiler()
                ->compile($command->getTemplate(), ['text' => $command->getText()]);
        }

        $this->driver->getHttp()->post(
            FacebookDriver::API_URL.'me/messages',
            [
                'query' => [
                    'access_token' => $this->driver->getParameter('page_token'),
                ],
                'json' => [
                    'recipient' => [
                        'id' => $command->getChat()->getId(),
                    ],
                    'message' => $payload,
                ],
            ]
        );
    }

    /**
     * Handle send attachment command.
     *
     * @param SendAttachment $command
     */
    public function handleSendAttachment(SendAttachment $command): void
    {
        $this->driver->getHttp()->post(
            FacebookDriver::API_URL.'me/messages',
            [
                'query' => [
                    'access_token' => $this->driver->getParameter('page_token'),
                ],
                'multipart' => [
                    [
                        'name' => 'recipient',
                        'contents' => json_encode([
                            'id' => $command->getChat()->getId(),
                        ]),
                    ],
                    [
                        'name' => 'message',
                        'contents' => json_encode([
                            'attachment' => [
                                'type' => $command->getAttachment()->getType(),
                                'payload' => [],
                            ],
                        ]),
                    ],
                    [
                        'name' => 'filedata',
                        'contents' => fopen($command->getAttachment()->getPath(), 'rb'),
                    ],
                ],
            ]
        );
    }

    /**
     * Handle send request command.
     *
     * @param SendRequest $command
     */
    public function handleSendRequest(SendRequest $command): void
    {
        // TODO: Implement handleSendRequest() method.
    }
}
