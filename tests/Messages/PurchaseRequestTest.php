<?php

namespace OmnipayTest\Klarna\Messages;

use Omnipay\Klarna\Messages\PurchaseRequest;

class PurchaseRequestTest extends KlarnaTestCase
{
    /**
     * @var PurchaseRequest
     */
    private $request;

    public function setUp(): void
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize($this->getPurchaseParams());
    }

    public function testEndpoint(): void
    {
        $authorizationToken = $this->request->getAuthorizationToken();

        self::assertSame('https://api.playground.klarna.com/payments/v1/authorizations/' . $authorizationToken . '/order', $this->request->getEndpoint());
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
