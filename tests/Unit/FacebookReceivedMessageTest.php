<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use FondBot\Templates\Location;
use FondBot\Templates\Attachment;
use Tests\Classes\FakeAttachmentsContainer;
use Tests\Classes\Contracts\PayloadInterface;
use Tests\Classes\Contents\FakeLocationContent;
use Tests\Classes\Contents\FakeAttachmentContent;
use FondBot\Drivers\Facebook\FacebookReceivedMessage;
use Tests\Classes\Contents\FakePostBackPayloadContent;
use Tests\Classes\Contents\FakeQuickReplyPayloadContent;

class FacebookReceivedMessageTest extends TestCase
{
    public function test_getText()
    {
        $text = $this->faker()->text;

        $received = new FacebookReceivedMessage(compact('text'));

        $this->assertSame($text, $received->getText());
        $this->assertNull($received->getLocation());
        $this->assertNull($received->getAttachment());
    }

    public function test_getLocation()
    {
        $fake = new FakeLocationContent;
        $attachments = new FakeAttachmentsContainer;
        $attachments->addAttachment($fake);

        $received = new FacebookReceivedMessage($attachments->toArray());

        $location = $received->getLocation();

        $this->assertInstanceOf(Location::class, $location);
        $this->assertSame($fake->getLatitude(), $location->getLatitude());
        $this->assertSame($fake->getLongitude(), $location->getLongitude());
        $this->assertNull($received->getText());
        $this->assertNull($received->getAttachment());
    }

    /**
     * @dataProvider payloadProvider
     *
     * @param \Tests\Classes\Contracts\PayloadInterface $container
     */
    public function test_getData(PayloadInterface $container)
    {
        $received = new FacebookReceivedMessage($container->toArray());

        $this->assertTrue($received->hasData());
        $this->assertSame($container->getPayload(), $received->getData());
    }

    /**
     * @dataProvider attachmentProvider
     *
     * @param \Tests\Classes\Contents\FakeAttachmentContent $fakeAttachmentContent
     */
    public function test_getAttachment(FakeAttachmentContent $fakeAttachmentContent)
    {
        $fakeAttachments = new FakeAttachmentsContainer;
        $fakeAttachments->addAttachment($fakeAttachmentContent);

        $received = new FacebookReceivedMessage($fakeAttachments->toArray());
        $attachment = $received->getAttachment();

        $this->assertInstanceOf(Attachment::class, $attachment);
        $this->assertNull($received->getText());
        $this->assertTrue($received->hasAttachment());
        $this->assertSame($fakeAttachmentContent->getUrl(), $attachment->getPath());
        $this->assertSame($fakeAttachmentContent->getType(), $attachment->getType());
    }

    public function attachmentProvider()
    {
        return [
            [new FakeAttachmentContent(FakeAttachmentContent::TYPE_IMAGE)],
            [new FakeAttachmentContent(FakeAttachmentContent::TYPE_AUDIO)],
            [new FakeAttachmentContent(FakeAttachmentContent::TYPE_FILE)],
            [new FakeAttachmentContent(FakeAttachmentContent::TYPE_VIDEO)],
        ];
    }

    public function payloadProvider()
    {
        return [
            [new FakeQuickReplyPayloadContent],
            [new FakePostBackPayloadContent],
        ];
    }
}
