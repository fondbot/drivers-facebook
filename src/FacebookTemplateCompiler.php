<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook;

use FondBot\Helpers\Arr;
use FondBot\Templates\Keyboard;
use FondBot\Drivers\TemplateCompiler;
use FondBot\Templates\Keyboard\Button;
use FondBot\Templates\Keyboard\UrlButton;
use FondBot\Templates\Keyboard\ReplyButton;
use FondBot\Templates\Keyboard\PayloadButton;

class FacebookTemplateCompiler extends TemplateCompiler
{
    /**
     * Compile keyboard.
     *
     * @see https://developers.facebook.com/docs/messenger-platform/send-api-reference/button-template
     *
     * @param Keyboard $keyboard
     * @param array $args
     *
     * @return mixed
     */
    protected function compileKeyboard(Keyboard $keyboard, array $args)
    {
        $buttons = collect($keyboard->getButtons())
            ->map(function (Button $button) {
                return $this->compile($button);
            })
            ->toArray();

        if (!$this->hasCustomButtons($keyboard)) {
            return [
                'text' => $args['text'],
                'quick_replies' => $buttons,
            ];
        }

        return [
            'attachment' => [
                'type' => 'template',
                'payload' => [
                    'template_type' => 'button',
                    'text' => $args['text'],
                    'buttons' => $buttons,
                ],
            ],
        ];
    }

    /**
     * Compile payload button.
     *
     * @param PayloadButton $button
     *
     * @param array $args
     *
     * @return mixed
     *
     * @see https://developers.facebook.com/docs/messenger-platform/send-api-reference/postback-button
     */
    protected function compilePayloadButton(PayloadButton $button, array $args)
    {
        return ['type' => 'postback', 'title' => $button->getLabel(), 'payload' => $button->getPayload()];
    }

    /**
     * Compile reply button.
     *
     * @param ReplyButton $button
     * @param array $args
     *
     * @return mixed
     * @see https://developers.facebook.com/docs/messenger-platform/send-api-reference/quick-replies
     */
    protected function compileReplyButton(ReplyButton $button, array $args)
    {
        return [
            'content_type' => 'text',
            'title' => $button->getLabel(),
            'payload' => $button->getLabel(),
        ];
    }

    /**
     * Compile url button.
     *
     * @param UrlButton $button
     *
     * @param array $args
     *
     * @return mixed
     * @see https://developers.facebook.com/docs/messenger-platform/send-api-reference/url-button
     */
    protected function compileUrlButton(UrlButton $button, array $args)
    {
        $payload = [
            'type' => 'web_url',
            'title' => $button->getLabel(),
            'url' => $button->getUrl(),
        ];

        if (Arr::has($button->getParameters(), ['webview_height_ratio'])) {
            $payload['webview_height_ratio'] = $button->getParameters()['webview_height_ratio'];
        }

        if (Arr::has($button->getParameters(), ['messenger_extensions'])) {
            $payload['messenger_extensions'] = $button->getParameters()['messenger_extensions'];
        }

        if (Arr::has($button->getParameters(), ['fallback_url'])) {
            $payload['fallback_url'] = $button->getParameters()['fallback_url'];
        }

        if (Arr::has($button->getParameters(), ['webview_share_button'])) {
            $payload['webview_share_button'] = $button->getParameters()['webview_share_button'];
        }

        return $payload;
    }

    /**
     * Determine if keyboard has custom buttons.
     *
     * @param Keyboard $keyboard
     *
     * @return bool
     */
    private function hasCustomButtons(Keyboard $keyboard): bool
    {
        return (bool) collect($keyboard->getButtons())->first(function (Button $button) {
            return $button instanceof UrlButton;
        });
    }
}
