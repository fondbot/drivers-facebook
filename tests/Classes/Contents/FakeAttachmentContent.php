<?php

declare(strict_types=1);

namespace Tests\Classes\Contents;

class FakeAttachmentContent extends AbstractContent
{
    const TYPE_IMAGE = 'image';
    const TYPE_AUDIO = 'audio';
    const TYPE_VIDEO = 'video';
    const TYPE_FILE = 'file';

    private $type;
    private $url;

    public function __construct(string $type, string $url = null)
    {
        $this->type = $type;
        $this->url = $url ?: $this->faker()->url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'payload' => [
                'url' => $this->url,
            ],
        ];
    }
}
