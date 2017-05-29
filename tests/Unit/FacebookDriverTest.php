<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use GuzzleHttp\Client;
use FondBot\Helpers\Str;
use FondBot\Drivers\Chat;
use FondBot\Drivers\User;
use FondBot\Http\Request;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use FondBot\Drivers\Commands\SendMessage;
use GuzzleHttp\Exception\RequestException;
use FondBot\Drivers\Facebook\FacebookDriver;
use FondBot\Drivers\Facebook\FacebookReceivedMessage;

/**
 * @property mixed|\Mockery\Mock|\Mockery\MockInterface guzzle
 * @property array                                      $parameters
 * @property FacebookDriver                             facebook
 */
class FacebookDriverTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->guzzle = $this->mock(Client::class);
        $this->facebook = new FacebookDriver($this->guzzle);
        $this->facebook->fill(
            $this->parameters = [
                'page_token' => Str::random(),
                'verify_token' => Str::random(),
                'app_secret' => Str::random(),
            ],
            new Request([], [])
        );
    }

    /**
     * @expectedException \FondBot\Drivers\Exceptions\InvalidRequest
     * @expectedExceptionMessage Header signature is not provided
     */
    public function test_verifyRequest_invalid_header(): void
    {
        $this->facebook->verifyRequest();
    }

    public function test_verifyRequest_skip_signature(): void
    {
        $request = new Request($data = $this->generateResponse(), $this->generateHeaders($data, Str::random()));

        $this->facebook->fill([], $request);

        $this->facebook->verifyRequest();
    }

    /**
     * @expectedException \FondBot\Drivers\Exceptions\InvalidRequest
     * @expectedExceptionMessage Invalid signature header
     */
    public function test_verifyRequest_invalid_secret(): void
    {
        $request = new Request($data = ['foo' => 'bar'], $this->generateHeaders($data, Str::random()));

        $this->facebook->fill($this->parameters, $request);

        $this->facebook->verifyRequest();
    }

    public function test_verifyRequest_valid_header(): void
    {
        $request = new Request($data = $this->generateResponse(), $this->generateHeaders($data, $this->parameters['app_secret']));
        $this->facebook->fill([], $request);

        $this->facebook->verifyRequest();
    }

    /**
     * @expectedException \FondBot\Drivers\Exceptions\InvalidRequest
     * @expectedExceptionMessage Invalid payload
     */
    public function test_verifyRequest_empty_message(): void
    {
        $request = new Request($data = ['foo' => 'bar'], $this->generateHeaders($data, $this->parameters['app_secret']));

        $this->facebook->fill($this->parameters, $request);

        $this->facebook->verifyRequest();
    }

    /**
     * @expectedException \FondBot\Drivers\Exceptions\InvalidRequest
     * @expectedExceptionMessage Invalid payload
     */
    public function test_verifyRequest_empty_message_from(): void
    {
        $data = [
            'entry' => [
                [
                    'messaging' => [
                        [
                            'message' => [
                                'text' => $this->faker()->word,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $request = new Request($data, $this->generateHeaders($data, $this->parameters['app_secret']));

        $this->facebook->fill($this->parameters, $request);

        $this->facebook->verifyRequest();
    }

    public function test_verifyRequest(): void
    {
        $request = new Request($data = $this->generateResponse(), $this->generateHeaders($data, $this->parameters['app_secret']));

        $this->facebook->fill($this->parameters, $request);

        $this->facebook->verifyRequest();
    }

    public function test_getSender(): void
    {
        $senderId = $this->faker()->uuid;
        $response = [
            'id' => $senderId,
            'first_name' => $this->faker()->firstName,
            'last_name' => $this->faker()->lastName,
            'profile_pic' => $this->faker()->url,
            'locale' => $this->faker()->locale,
            'timezone' => $this->faker()->randomDigit,
            'gender' => $this->faker()->word,
        ];

        $request = new Request($this->generateResponse($senderId), []);

        $this->facebook->fill($this->parameters, $request);

        $stream = $this->mock(ResponseInterface::class);

        $stream->shouldReceive('getBody')->andReturn(json_encode($response))->atLeast()->once();
        $this->guzzle->shouldReceive('get')
            ->with('https://graph.facebook.com/v2.6/'.$senderId, [
                'query' => [
                    'access_token' => $this->parameters['page_token'],
                ],
            ])
            ->andReturn($stream)
            ->atLeast()->once();

        $sender = $this->facebook->getUser();

        $this->assertInstanceOf(User::class, $sender);
        $this->assertSame($senderId, $sender->getId());
        $this->assertSame($response['first_name'].' '.$response['last_name'], $sender->getName());
        $this->assertNull($sender->getUsername());

        $this->assertSame($sender, $this->facebook->getUser());
    }

    /**
     * @expectedException \FondBot\Drivers\Exceptions\InvalidRequest
     * @expectedExceptionMessage Can not get user profile
     */
    public function test_getSender_exception(): void
    {
        $senderId = $this->faker()->uuid;
        $request = new Request($this->generateResponse($senderId), []);

        $this->facebook->fill($this->parameters, $request);

        $this->guzzle->shouldReceive('get')
            ->with('https://graph.facebook.com/v2.6/'.$senderId, [
                'query' => [
                    'access_token' => $this->parameters['page_token'],
                ],
            ])
            ->andThrow(new RequestException('Invalid request', $this->mock(RequestInterface::class)));

        $result = $this->facebook->getUser();
        $this->assertInstanceOf(User::class, $result);
    }

    public function test_getMessage(): void
    {
        $request = new Request($this->generateResponse(null, $text = $this->faker()->text()), []);
        $this->facebook->fill($this->parameters, $request);

        $message = $this->facebook->getMessage();
        $this->assertInstanceOf(FacebookReceivedMessage::class, $message);
        $this->assertFalse($message->hasAttachment());
        $this->assertSame($text, $message->getText());
        $this->assertNull($message->getLocation());
    }

    public function test_getChat(): void
    {
        $id = $this->faker()->uuid;
        $request = new Request($this->generateResponse($id), []);

        $this->facebook->fill($this->parameters, $request);

        $chat = $this->facebook->getChat();

        $this->assertInstanceOf(Chat::class, $chat);
        $this->assertSame($id, $chat->getId());
        $this->assertSame(Chat::TYPE_PRIVATE, $chat->getType());
        $this->assertSame('', $chat->getTitle());
    }

    public function test_verify_webhook_check(): void
    {
        $request = new Request([
            'hub_mode' => 'subscribe',
            'hub_verify_token' => $this->parameters['verify_token'],
            'hub_challenge' => $challenge = $this->faker()->randomNumber(),
        ], []);

        $this->facebook->fill($this->parameters, $request);

        $this->assertTrue($this->facebook->isVerificationRequest());
        $this->assertEquals($challenge, $this->facebook->verifyWebhook());
    }

    /**
     * @expectedException \FondBot\Drivers\Exceptions\InvalidRequest
     * @expectedExceptionMessage Invalid verify token
     */
    public function test_verifyWebhook_invalid_token(): void
    {
        $request = new Request([
            'hub_mode' => 'subscribe',
            'hub_verify_token' => $this->faker()->word,
            'hub_challenge' => $challenge = $this->faker()->randomNumber(),
        ], []);
        $this->facebook->fill($this->parameters, $request);

        $this->assertTrue($this->facebook->isVerificationRequest());
        $this->facebook->verifyWebhook();
    }

    public function test_handle(): void
    {
        $id = $this->faker()->uuid;
        $text = $this->faker()->word;

        $chat = new Chat($id, '');
        $user = new User($id);
        $command = new SendMessage($chat, $user, $text);

        $this->guzzle->shouldReceive('post');

        $this->facebook->handle($command);
    }

    private function generateSignature(array $data, $key): string
    {
        return 'sha1='.hash_hmac('sha1', json_encode($data), $key);
    }

    private function generateResponse(string $id = null, string $text = null): array
    {
        return [
            'entry' => [
                [
                    'messaging' => [
                        [
                            'sender' => ['id' => $id ?: $this->faker()->uuid],
                            'message' => ['text' => $text ?: $this->faker()->word],
                        ],
                    ],
                ],
            ],
        ];
    }

    private function generateHeaders(array $data, $key): array
    {
        return [
            'x-hub-signature' => [$this->generateSignature($data, $key)],
        ];
    }
}
