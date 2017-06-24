<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook;

use FondBot\Drivers\Chat;
use FondBot\Drivers\CommandHandler;
use FondBot\Drivers\Driver;
use FondBot\Drivers\Exceptions\InvalidRequest;
use FondBot\Drivers\Extensions\WebhookVerification;
use FondBot\Drivers\ReceivedMessage;
use FondBot\Drivers\TemplateCompiler;
use FondBot\Drivers\User;
use GuzzleHttp\Exception\RequestException;

class FacebookDriver extends Driver implements WebhookVerification
{
    public const API_URL = 'https://graph.facebook.com/v2.6/';

    /** @var User|null */
    private $sender;

    /**
     * Get template compiler instance.
     *
     * @return TemplateCompiler|null
     */
    public function getTemplateCompiler(): ?TemplateCompiler
    {
        return new FacebookTemplateCompiler;
    }

    /**
     * Get command handler instance.
     *
     * @return CommandHandler
     */
    public function getCommandHandler(): CommandHandler
    {
        return new FacebookCommandHandler($this);
    }

    /**
     * Verify incoming request data.
     *
     * @throws InvalidRequest
     */
    public function verifyRequest(): void
    {
        $this->verifySignature();

        if (!$this->request->hasParameters(['entry.0.messaging.0.sender.id', 'entry.0.messaging.0.message'])) {
            throw new InvalidRequest('Invalid payload');
        }
    }

    /**
     * Whether current request type is verification.
     *
     * @return bool
     */
    public function isVerificationRequest(): bool
    {
        return $this->request->getParameter('hub_mode') === 'subscribe' && $this->request->getParameter('hub_verify_token');
    }

    /**
     * Run webhook verification and respond if required.
     * @return mixed
     * @throws InvalidRequest
     */
    public function verifyWebhook()
    {
        if ($this->request->getParameter('hub_verify_token') === $this->getParameter('verify_token')) {
            return $this->request->getParameter('hub_challenge');
        }

        throw new InvalidRequest('Invalid verify token');
    }

    /**
     * Get current chat.
     *
     * @return Chat
     */
    public function getChat(): Chat
    {
        $id = $this->request->getParameter('entry.0.messaging.0.sender.id');

        return new Chat($id, '');
    }

    /**
     * Get message sender.
     * @return User
     * @throws InvalidRequest
     */
    public function getUser(): User
    {
        if ($this->sender instanceof User) {
            return $this->sender;
        }

        $id = $this->request->getParameter('entry.0.messaging.0.sender.id');

        try {
            $response = $this->http->get(self::API_URL.$id, $this->getDefaultRequestParameters());
            $user = json_decode((string) $response->getBody(), true);

            return $this->sender = new User(
                (string) $id,
                $this->resolveUserName($user)
            );
        } catch (RequestException $exception) {
            throw new InvalidRequest('Can not get user profile', 0, $exception);
        }
    }

    /**
     * Get message received from sender.
     *
     * @return ReceivedMessage
     */
    public function getMessage(): ReceivedMessage
    {
        return new FacebookReceivedMessage($this->request->getParameter('entry.0.messaging.0.message'));
    }

    protected function getDefaultRequestParameters(): array
    {
        return [
            'query' => [
                'access_token' => $this->getParameter('page_token'),
            ],
        ];
    }

    protected function verifySignature(): void
    {
        if (!$secret = $this->getParameter('app_secret')) {
            // If app secret non set, just skip this check
            return;
        }

        if (!$header = $this->request->getHeader('x-hub-signature')[0] ?? null) {
            throw new InvalidRequest('Header signature is not provided');
        }

        if (!hash_equals($header, 'sha1='.hash_hmac('sha1', json_encode($this->request->getParameters()), $secret))) {
            throw new InvalidRequest('Invalid signature header');
        }
    }

    protected function resolveUserName(array $user = []): string
    {
        if (array_key_exists('name', $user)) {
            return trim($user['name']);
        }

        $name = [$user['first_name'] ?? null, $user['last_name'] ?? null];

        return trim(implode(" ", $name));
    }
}
