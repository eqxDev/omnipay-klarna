<?php

namespace OmnipayTest\Klarna\Messages;

use Omnipay\Klarna\Messages\CaptureRequest;

class CaptureRequestTest extends KlarnaTestCase
{
    /**
     * @var CaptureRequest
     */
    private $request;

    public function setUp(): void
    {
        $this->request = new CaptureRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize($this->getCaptureParams());
    }

    public function testEndpoint(): void
    {
        $authorizationToken = $this->request->getAuthorizationToken();

        self::assertSame('https://api.playground.klarna.com/payments/v1/authorizations/' . $authorizationToken . '/order', $this->request->getEndpoint());
    }


    public function testSendSuccess(): void
    {
        $this->setMockHttpResponse('CaptureSuccess.txt');
        $response = $this->request->send();

        self::assertTrue($response->isSuccessful());
    }

    public function testSendError(): void
    {
        $this->setMockHttpResponse('CaptureFailure.txt');
        $response = $this->request->send();

        self::assertFalse($response->isSuccessful());
        self::assertNull($response->getTransactionReference());
        self::assertSame('NOT_FOUND', $response->getCode());
    }
}
