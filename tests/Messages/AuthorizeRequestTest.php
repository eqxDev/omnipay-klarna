<?php

namespace OmnipayTest\Klarna\Messages;

use Omnipay\Klarna\Messages\AuthorizeRequest;

class AuthorizeRequestTest extends KlarnaTestCase
{
    /**
     * @var AuthorizeRequest
     */
    private $request;

    public function setUp(): void
    {
        $this->request = new AuthorizeRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize($this->getAuthorizeParams());
    }

    public function testEndpoint(): void
    {
        self::assertSame('https://api.playground.klarna.com/payments/v1/sessions', $this->request->getEndpoint());
    }

    public function testSendSuccess(): void
    {
        $this->setMockHttpResponse('AuthorizeSuccess.txt');
        $response = $this->request->send();

        self::assertTrue($response->isSuccessful());
    }

    public function testSendError(): void
    {
        $this->setMockHttpResponse('AuthorizeFailure.txt');
        $response = $this->request->send();

        self::assertFalse($response->isSuccessful());
        self::assertNull($response->getTransactionReference());
        self::assertSame('BAD_VALUE', $response->getCode());
    }
}
