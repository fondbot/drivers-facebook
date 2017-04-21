<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates;

use FondBot\Contracts\Arrayable;
use JsonSerializable;

class ReceiptTemplate implements Arrayable, JsonSerializable
{
    private $orderNumber;
    private $recipientName;
    private $currency;

    public function __construct(string $orderNumber, string $recipientName, string $currency)
    {
        $this->orderNumber = $orderNumber;
        $this->recipientName = $recipientName;
        $this->currency = $currency;
    }

    public function toArray(): array
    {
        return [
            'attachment' => [
                'type' => 'template',
                'payload' => [
                    'template_type' => 'receipt',
                    'recipient_name' => $this->recipientName,
                    'merchant_name' => '',
                    'order_number' => $this->orderNumber,
                    'currency' => $this->currency,
                ],
            ],
        ];
    }

    function jsonSerialize()
    {
        return $this->toArray();
    }
}