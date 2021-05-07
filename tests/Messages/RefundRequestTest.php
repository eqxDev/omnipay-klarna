<?php

namespace OmnipayTest\Klarna\Messages;

use Omnipay\Klarna\Messages\RefundRequest;

class RefundRequestTest extends KlarnaTestCase
{
    /**
     * @var RefundRequest
     */
    private $request;

    public function setUp(): void
    {
        $this->request = new RefundRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize($this->getRefundParams());
    }

    public function testEndpoint(): void
    {
        $orderId = $this->request->getTransactionReference();

        self::assertSame('https://api.playground.klarna.com/ordermanagement/v1/orders/' . $orderId . '/refunds', $this->request->getEndpoint());
    }


    public function testSendSuccess(): void
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');
        $response = $this->request->send();

        self::assertTrue($response->isSuccessful());
    }

    public function testSendError(): void
    {
        $this->setMockHttpResponse('PurchaseFailure.txt');
        $response = $this->request->send();

        self::assertFalse($response->isSuccessful());
        self::assertNull($response->getTransactionReference());
        self::assertSame('NOT_FOUND', $response->getCode());
    }
}
