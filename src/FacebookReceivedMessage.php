<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook;

use GuzzleHttp\Client;
use FondBot\Drivers\ReceivedMessage;
use FondBot\Drivers\ReceivedMessage\Location;
use FondBot\Drivers\ReceivedMessage\Attachment;

class FacebookReceivedMessage implements ReceivedMessage
{
    private $guzzle;
    private $payload;

    public function __construct(Client $guzzle, array $payload)
    {
        $this->guzzle = $guzzle;
        $this->payload = $payload;
    }

    /**
     * Get text.
     *
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->payload['text'] ?? null;
    }

    /**
     * Get location.
     *
     * @return Location|null
     */
    public function getLocation(): ?Location
    {
        if ($location = $this->getAttachmentPayload('location')) {
            return new Location(
                $location['coordinates']['lat'],
                $location['coordinates']['long']
            );
        }

        return null;
    }

    /**
     * Determine if message has attachment.
     *
     * @return bool
     */
    public function hasAttachment(): bool
    {
        return isset($this->payload['attachments']) && collect($this->payload['attachments'])
                ->whereIn('type', ['audio', 'file', 'image', 'video'])
                ->count() > 0;
    }

    /**
     * Get attachment.
     *
     * @return Attachment|null
     */
    public function getAttachment(): ?Attachment
    {
        return $this->getImage()
            ?? $this->getAudio()
            ?? $this->getVideo()
            ?? $this->getFile();
    }

    /**
     * Determine if message has data payload.
     *
     * @return bool
     */
    public function hasData(): bool
    {
        return false;
    }

    /**
     * Get data payload.
     *
     * @return string|null
     */
    public function getData(): ?string
    {
        return null;
    }

    /**
     * Get image.
     *
     * @return Attachment|null
     */
    public function getImage(): ?Attachment
    {
        if ($image = $this->getAttachmentPayload('image')) {
            return new Attachment(Attachment::TYPE_IMAGE, $image['url'], $this->guzzle);
        }

        return null;
    }

    /**
     * Get audio.
     *
     * @return Attachment|null
     */
    public function getAudio(): ?Attachment
    {
        if ($audio = $this->getAttachmentPayload('audio')) {
            return new Attachment(Attachment::TYPE_AUDIO, $audio['url'], $this->guzzle);
        }

        return null;
    }

    /**
     * Get video.
     *
     * @return Attachment|null
     */
    public function getVideo(): ?Attachment
    {
        if ($video = $this->getAttachmentPayload('video')) {
            return new Attachment(Attachment::TYPE_VIDEO, $video['url'], $this->guzzle);
        }

        return null;
    }

    /**
     * Get file.
     *
     * @return Attachment|null
     */
    public function getFile(): ?Attachment
    {
        if ($file = $this->getAttachmentPayload('file')) {
            return new Attachment(Attachment::TYPE_FILE, $file['url'], $this->guzzle);
        }

        return null;
    }

    private function getAttachmentPayload(string $type): ?array
    {
        if (!$attachments = $this->payload['attachments'] ?? null) {
            return null;
        }

        // Is it real to send many locations or something in one request?
        return collect($attachments)->first(function ($attachment) use ($type) {
            return $attachment['type'] === $type;
        })['payload'] ?? null;
    }
}
