<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates;

use FondBot\Conversation\Template;
use FondBot\Drivers\Facebook\Templates\Objects\Address;
use FondBot\Drivers\Facebook\Templates\Objects\Adjustment;
use FondBot\Drivers\Facebook\Templates\Objects\Element;
use FondBot\Drivers\Facebook\Templates\Objects\Summary;

class ReceiptTemplate implements Template
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

    public function setMerchantName(string $merchantName): ReceiptTemplate
    {
        $this->merchantName = $merchantName;

        return $this;
    }

    public function setTimestamp(string $timestamp): ReceiptTemplate
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function setOrderUrl(string $orderUrl): ReceiptTemplate
    {
        $this->orderUrl = $orderUrl;

        return $this;
    }

    public function addElement(Element $element)
    {
        $this->elements[] = $element->toArray();

        return $this;
    }

    public function setElements(array $elements): ReceiptTemplate
    {
        $this->elements = array_map(function (Element $element) {
            return $element->toArray();
        }, $elements);

        return $this;
    }

    public function setAddress(Address $address): ReceiptTemplate
    {
        $this->address = $address->toArray();

        return $this;
    }

    public function addAdjustment(Adjustment $adjustment): ReceiptTemplate
    {
        $this->adjustments[] = $adjustment->toArray();

        return $this;
    }

    public function setAdjustments(array $adjustments): ReceiptTemplate
    {
        $this->adjustments = array_map(function (Adjustment $adjustment) {
            return $adjustment->toArray();
        }, $adjustments);

        return $this;
    }

    public function setOrderNumber(string $orderNumber): ReceiptTemplate
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    public function setRecipientName(string $recipientName): ReceiptTemplate
    {
        $this->recipientName = $recipientName;

        return $this;
    }

    public function setCurrency(string $currency): ReceiptTemplate
    {
        $this->currency = $currency;

        return $this;
    }

    public function setPaymentMethod(string $paymentMethod): ReceiptTemplate
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    public function setSummary(Summary $summary): ReceiptTemplate
    {
        $this->summary = $summary->toArray();

        return $this;
    }
}
