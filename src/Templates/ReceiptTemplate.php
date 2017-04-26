<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates;

use FondBot\Drivers\Facebook\Templates\Objects\Address;
use FondBot\Drivers\Facebook\Templates\Objects\Adjustment;
use FondBot\Drivers\Facebook\Templates\Objects\Element;
use FondBot\Drivers\Facebook\Templates\Objects\Summary;

class ReceiptTemplate implements TemplateInterface
{
    private $orderNumber;
    private $merchantName;
    private $recipientName;
    private $currency;
    private $paymentMethod;
    private $timestamp;
    private $orderUrl;
    private $elements;
    private $address;
    private $summary;
    private $adjustments;

    public function __construct(
        string $orderNumber,
        string $recipientName,
        string $currency,
        string $paymentMethod,
        Summary $summary
    ) {
        $this->orderNumber = $orderNumber;
        $this->recipientName = $recipientName;
        $this->currency = $currency;
        $this->paymentMethod = $paymentMethod;
        $this->summary = $summary->toArray();
    }

    public static function create(
        string $orderNumber,
        string $recipientName,
        string $currency,
        string $paymentMethod,
        Summary $summary
    ): ReceiptTemplate {
        return new static($orderNumber, $recipientName, $currency, $paymentMethod, $summary);
    }

    public function toArray(): array
    {
        return [
            'attachment' => [
                'type' => 'template',
                'payload' => [
                    'template_type' => 'receipt',
                    'recipient_name' => $this->recipientName,
                    'merchant_name' => $this->merchantName,
                    'order_number' => $this->orderNumber,
                    'currency' => $this->currency,
                    'payment_method' => $this->paymentMethod,
                    'timestamp' => $this->timestamp,
                    'order_url' => $this->orderUrl,
                    'elements' => $this->elements,
                    'address' => $this->address,
                    'summary' => $this->summary,
                    'adjustments' => $this->adjustments,
                ],
            ],
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    public function getMerchantName(): ?string
    {
        return $this->merchantName;
    }

    public function setMerchantName(string $merchantName): ReceiptTemplate
    {
        $this->merchantName = $merchantName;

        return $this;
    }

    public function getRecipientName(): string
    {
        return $this->recipientName;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }

    public function getTimestamp(): ?string
    {
        return $this->timestamp;
    }

    public function setTimestamp(string $timestamp): ReceiptTemplate
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getOrderUrl(): ?string
    {
        return $this->orderUrl;
    }

    public function setOrderUrl(string $orderUrl): ReceiptTemplate
    {
        $this->orderUrl = $orderUrl;

        return $this;
    }

    /**
     * @return array|null|Element[]
     */
    public function getElements(): ?array
    {
        return $this->elements;
    }

    public function addElement(Element $element)
    {
        $this->elements[] = $element->toArray();

        return $this;
    }

    public function getAddress(): ?array
    {
        return $this->address;
    }

    public function setAddress(Address $address): ReceiptTemplate
    {
        $this->address = $address->toArray();

        return $this;
    }

    public function getSummary(): array
    {
        return $this->summary;
    }

    /**
     * @return array|null|Adjustment[]
     */
    public function getAdjustments(): ?array
    {
        return $this->adjustments;
    }

    public function addAdjustment(Adjustment $adjustment): ReceiptTemplate
    {
        $this->adjustments[] = $adjustment->toArray();

        return $this;
    }
}