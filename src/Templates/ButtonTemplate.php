<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates;

class ButtonTemplate implements TemplateInterface
{
    private $text;
    private $buttons;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public static function create(string $text): ButtonTemplate
    {
        return new static($text);
    }

    public function toArray(): array
    {
        return [
            'attachment' => [
                'type' => 'template',
                'payload' => [
                    'template_type' => 'button',
                    'text' => $this->text,
                    'buttons' => $this->buttons,
                ],
            ],
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function addUrlButton(string $url, string $title, array $parameters = []): ButtonTemplate
    {
        $this->buttons[] = [
                'type' => 'web_url',
                'url' => $url,
                'title' => $title,
            ] + $parameters;

        return $this;
    }

    public function addPostBackButton(string $title, string $payload): ButtonTemplate
    {
        $this->buttons[] = [
            'type' => 'postback',
            'title' => $title,
            'payload' => $payload,
        ];

        return $this;
    }

    public function addCallButton(string $title, string $phone): ButtonTemplate
    {
        $this->buttons[] = [
            'type' => 'phone_number',
            'title' => $title,
            'payload' => $phone,
        ];

        return $this;
    }
}