<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates;

use FondBot\Contracts\Template;
use FondBot\Contracts\Arrayable;
use FondBot\Drivers\Facebook\Templates\ReceiptTemplate\Address;
use FondBot\Drivers\Facebook\Templates\ReceiptTemplate\Element;
use FondBot\Drivers\Facebook\Templates\ReceiptTemplate\Summary;
use FondBot\Drivers\Facebook\Templates\ReceiptTemplate\Adjustment;

class ReceiptTemplate implements Template, Arrayable
{
    private $sharable = false;
    private $recipientName;
    private $merchantName;
    private $orderNumber;
    private $currency;
    private $paymentMethod;
    private $timestamp;
    private $orderUrl;
    private $elements;
    private $address;
    private $summary;
    private $adjustments;

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'Receipt';
    }

    /**
     * Set sharable.
     *
     * @param bool $sharable
     *
     * @return ReceiptTemplate
     */
    public function setSharable(bool $sharable): ReceiptTemplate
    {
        $this->sharable = $sharable;

        return $this;
    }

    /**
     * Set recipient name.
     *
     * @param string $recipientName
     *
     * @return ReceiptTemplate
     */
    public function setRecipientName(string $recipientName): ReceiptTemplate
    {
        $this->recipientName = $recipientName;

        return $this;
    }

    /**
     * Set merchant name.
     *
     * @param string $merchantName
     *
     * @return ReceiptTemplate
     */
    public function setMerchantName(string $merchantName): ReceiptTemplate
    {
        $this->merchantName = $merchantName;

        return $this;
    }

    /**
     * Set order number.
     *
     * @param string $orderNumber
     *
     * @return ReceiptTemplate
     */
    public function setOrderNumber(string $orderNumber): ReceiptTemplate
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    /**
     * Set currency.
     *
     * @param string $currency
     *
     * @return ReceiptTemplate
     */
    public function setCurrency(string $currency): ReceiptTemplate
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Set payment method.
     *
     * @param string $paymentMethod
     *
     * @return ReceiptTemplate
     */
    public function setPaymentMethod(string $paymentMethod): ReceiptTemplate
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * Set timestamp.
     *
     * @param string $timestamp
     *
     * @return ReceiptTemplate
     */
    public function setTimestamp(string $timestamp): ReceiptTemplate
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Set order URL.
     *
     * @param string $orderUrl
     *
     * @return ReceiptTemplate
     */
    public function setOrderUrl(string $orderUrl): ReceiptTemplate
    {
        $this->orderUrl = $orderUrl;

        return $this;
    }

    /**
     * Add element.
     *
     * @param Element $element
     *
     * @return $this
     */
    public function addElement(Element $element)
    {
        $this->elements[] = $element->toArray();

        return $this;
    }

    /**
     * Set address.
     *
     * @param Address $address
     *
     * @return ReceiptTemplate
     */
    public function setAddress(Address $address): ReceiptTemplate
    {
        $this->address = $address->toArray();

        return $this;
    }

    /**
     * Set summary.
     *
     * @param Summary $summary
     *
     * @return ReceiptTemplate
     */
    public function setSummary(Summary $summary): ReceiptTemplate
    {
        $this->summary = $summary->toArray();

        return $this;
    }

    /**
     * Add adjustment.
     *
     * @param Adjustment $adjustment
     *
     * @return ReceiptTemplate
     */
    public function addAdjustment(Adjustment $adjustment): ReceiptTemplate
    {
        $this->adjustments[] = $adjustment->toArray();

        return $this;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
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
}
