<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook;

use GuzzleHttp\Client;
use FondBot\Drivers\Driver;
use FondBot\Contracts\Drivers\User;
use GuzzleHttp\Exception\RequestException;
use FondBot\Contracts\Conversation\Keyboard;
use FondBot\Contracts\Drivers\InvalidRequest;
use FondBot\Contracts\Drivers\OutgoingMessage;
use FondBot\Contracts\Drivers\ReceivedMessage;
use FondBot\Contracts\Drivers\Extensions\WebhookVerification;

class FacebookDriver extends Driver implements WebhookVerification
{
    const API_URL = 'https://graph.facebook.com/v2.6/';

    private $guzzle;

    /** @var User|null */
    private $sender;

    public function __construct(Client $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    /**
     * Configuration parameters.
     *
     * @return array
     */
    public function getConfig(): array
    {
        return [
            'page_token',
            'verify_token',
            'app_secret',
        ];
    }

    /**
     * Verify incoming request data.
     *
     * @throws InvalidRequest
     */
    public function verifyRequest(): void
    {
        $this->verifySignature();

        if (!$this->hasRequest('entry.0.messaging.0.sender.id') || !$this->hasRequest('entry.0.messaging.0.message')) {
            throw new InvalidRequest('Invalid payload');
        }
    }

    /**
     * Get message sender.
     * @return User
     * @throws InvalidRequest
     */
    public function getUser(): User
    {
        if ($this->sender !== null) {
            return $this->sender;
        }

        $id = $this->getRequest('entry.0.messaging.0.sender.id');

        try {
            $response = $this->guzzle->get(self::API_URL.$id, $this->getDefaultRequestParameters());
            $user = json_decode((string) $response->getBody(), true);

            $user['id'] = $id;

            return $this->sender = new FacebookUser($user);
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
        return new FacebookReceivedMessage($this->guzzle, $this->getRequest('entry.0.messaging.0.message'));
    }

    /**
     * Send reply to participant.
     *
     * @param User $sender
     * @param string $text
     * @param Keyboard|null $keyboard
     *
     * @return OutgoingMessage
     */
    public function sendMessage(User $sender, string $text, Keyboard $keyboard = null): OutgoingMessage
    {
        $message = new FacebookOutgoingMessage($sender, $text, $keyboard);

        $this->guzzle->post(
            self::API_URL.'me/messages',
            $this->getDefaultRequestParameters() + ['form_params' => $message->toArray()]
        );

        return $message;
    }

    /**
     * Whether current request type is verification.
     *
     * @return bool
     */
    public function isVerificationRequest(): bool
    {
        return $this->getRequest('hub_mode') === 'subscribe' && $this->hasRequest('hub_verify_token');
    }

    /**
     * Run webhook verification and respond if required.
     * @return mixed
     * @throws InvalidRequest
     */
    public function verifyWebhook()
    {
        if ($this->getRequest('hub_verify_token') === $this->getParameter('verify_token')) {
            return $this->getRequest('hub_challenge');
        }

        throw new InvalidRequest('Invalid verify token');
    }

    private function getDefaultRequestParameters(): array
    {
        return [
            'query' => [
                'access_token' => $this->getParameter('page_token'),
            ],
        ];
    }

    private function verifySignature(): void
    {
        if (!$secret = $this->getParameter('app_secret')) {
            // If app secret non set, just skip this check
            return;
        }

        if (!$header = $this->getHeader('x-hub-signature')[0] ?? null) {
            throw new InvalidRequest('Header signature is not provided');
        }

        if (!hash_equals($header, 'sha1='.hash_hmac('sha1', json_encode($this->getRequest()), $secret))) {
            throw new InvalidRequest('Invalid signature header');
        }
    }
}
