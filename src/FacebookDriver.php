<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook;

use FondBot\Drivers\Chat;
use GuzzleHttp\Client;
use FondBot\Drivers\User;
use FondBot\Drivers\Driver;
use FondBot\Drivers\Command;
use FondBot\Drivers\ReceivedMessage;
use FondBot\Queue\SerializesForQueue;
use GuzzleHttp\Exception\RequestException;
use FondBot\Drivers\Exceptions\InvalidRequest;
use FondBot\Drivers\Extensions\WebhookVerification;

class FacebookDriver extends Driver implements WebhookVerification
{
    use SerializesForQueue;

    protected const API_URL = 'https://graph.facebook.com/v2.6/';

    protected $guzzle;

    /** @var User|null */
    protected $sender;

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
            $response = $this->getGuzzle()->get(self::API_URL.$id, $this->getDefaultRequestParameters());
            $user = json_decode((string) $response->getBody(), true);
            $user['id'] = (string) $id;

            return $this->sender = new User(
                $user['id'],
                "{$user['first_name']} {$user['last_name']}"
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
        return new FacebookReceivedMessage($this->getRequest('entry.0.messaging.0.message'));
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

        if (!$header = $this->getHeader('x-hub-signature')[0] ?? null) {
            throw new InvalidRequest('Header signature is not provided');
        }

        if (!hash_equals($header, 'sha1='.hash_hmac('sha1', json_encode($this->getRequest()), $secret))) {
            throw new InvalidRequest('Invalid signature header');
        }
    }

    /**
     * Handle command.
     *
     * @param Command $command
     */
    public function handle(Command $command): void
    {
        $content = ContentResolver::resolve($command);

        $this->getGuzzle()->post(
            self::API_URL.'me/messages',
            $this->getDefaultRequestParameters() + [$content->encodeType() => $content->toArray()]
        );
    }

    protected function getGuzzle()
    {
        return $this->guzzle ?: new Client();
    }

    /**
     * Get current chat.
     *
     * @return Chat
     */
    public function getChat(): Chat
    {
        $id = $this->getRequest('entry.0.messaging.0.sender.id');

        return new Chat($id, '');
    }
}
