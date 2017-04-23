<?php

namespace Tests\Unit\Templates;

use FondBot\Drivers\Facebook\Templates\Objects\Address;
use FondBot\Drivers\Facebook\Templates\Objects\Adjustment;
use FondBot\Drivers\Facebook\Templates\Objects\Element;
use FondBot\Drivers\Facebook\Templates\Objects\Summary;
use FondBot\Drivers\Facebook\Templates\ReceiptTemplate;
use Tests\TestCase;

class ReceiptTemplateTest extends TestCase
{
    public function test_default()
    {
        $summary = $this->mock(Summary::class);
        $element = $this->mock(Element::class);
        $address = $this->mock(Address::class);
        $adjustment = $this->mock(Adjustment::class);

        $summary->shouldReceive('transform')->andReturn([]);
        $element->shouldReceive('transform')->andReturn([]);
        $address->shouldReceive('transform')->andReturn([]);
        $adjustment->shouldReceive('transform')->andReturn([]);

        $summary->shouldReceive('jsonSerialize')->andReturn([]);
        $element->shouldReceive('jsonSerialize')->andReturn([]);
        $address->shouldReceive('jsonSerialize')->andReturn([]);
        $adjustment->shouldReceive('jsonSerialize')->andReturn([]);

        $template = ReceiptTemplate::create(
            $orderNumber = $this->faker()->uuid,
            $recipientName = $this->faker()->firstName,
            $currency = $this->faker()->currencyCode,
            $paymentMethod = $this->faker()->creditCardType . ' ' . $this->faker()->creditCardNumber,
            $summary
        );

        $template->setMerchantName($merchantName = $this->faker()->word);
        $template->setTimestamp($timestamp = (string)$this->faker()->unixTime);
        $template->setOrderUrl($url = $this->faker()->url);

        $this->assertSame($orderNumber, $template->getOrderNumber());
        $this->assertSame($recipientName, $template->getRecipientName());
        $this->assertSame($currency, $template->getCurrency());
        $this->assertSame($paymentMethod, $template->getPaymentMethod());
        $this->assertSame($summary, $template->getSummary());
        $this->assertSame($merchantName, $template->getMerchantName());
        $this->assertSame($timestamp, $template->getTimestamp());
        $this->assertSame($url, $template->getOrderUrl());

        $template->addElement($element);
        $this->assertSame($elements = [$element], $template->getElements());

        $template->setAddress($address);
        $this->assertSame($address, $template->getAddress());

        $template->addAdjustment($adjustment);
        $this->assertSame($adjustments = [$adjustment], $template->getAdjustments());

        $result = [
            'attachment' => [
                'type' => 'template',
                'payload' => [
                    'template_type' => 'receipt',
                    'recipient_name' => $recipientName,
                    'merchant_name' => $merchantName,
                    'order_number' => $orderNumber,
                    'currency' => $currency,
                    'payment_method' => $paymentMethod,
                    'timestamp' => $timestamp,
                    'order_url' => $url,
                    'elements' => $elements,
                    'address' => $address,
                    'summary' => $summary,
                    'adjustments' => $adjustments,
                ],
            ],
        ];

        $this->assertSame($result, $template->toArray());

        $this->assertSame(json_encode($result), json_encode($template));
    }
}