<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates\Buttons;

/**
 * Class UrlButton
 *
 * @see https://developers.facebook.com/docs/messenger-platform/send-api-reference/url-button
 *
 * @package FondBot\Drivers\Facebook\Templates\Buttons
 */
class UrlButton implements Button
{
    private const WEB_VIEW_COMPACT = 'compact';
    private const WEB_VIEW_TALL = 'tall';
    private const WEB_VIEW_FULL = 'full';

    private $title;
    private $url;
    private $webViewHeightRatio = self::WEB_VIEW_COMPACT;
    private $messengerExtensions;
    private $fallbackUrl;
    private $webViewShareButton;

    public function toArray(): array
    {
        return [
            'type' => 'web_url',
            'url' => $this->url,
            'title' => $this->title,
            'webview_height_ratio' => $this->webViewHeightRatio,
            'messenger_extensions' => $this->messengerExtensions,
            'fallback_url' => $this->fallbackUrl,
            'webview_share_button' => $this->webViewShareButton,
        ];
    }

    public function setWebViewCompact(): UrlButton
    {
        $this->webViewHeightRatio = self::WEB_VIEW_COMPACT;

        return $this;
    }

    public function setWebViewTall(): UrlButton
    {
        $this->webViewHeightRatio = self::WEB_VIEW_TALL;

        return $this;
    }

    public function setWebViewFull(): UrlButton
    {
        $this->webViewHeightRatio = self::WEB_VIEW_FULL;

        return $this;
    }

    public function setMessengerExtensions(bool $flag): UrlButton
    {
        $this->messengerExtensions = $flag;

        return $this;
    }

    public function setFallbackUrl(string $url): UrlButton
    {
        $this->fallbackUrl = $url;

        return $this;
    }

    public function setWebViewShareButton(string $value = 'hide'): UrlButton
    {
        $this->webViewShareButton = $value;

        return $this;
    }

    public function setTitle(string $title): UrlButton
    {
        $this->title = $title;

        return $this;
    }

    public function setUrl(string $url): UrlButton
    {
        $this->url = $url;

        return $this;
    }
}