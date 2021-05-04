<?php

namespace OmnipayTest\Klarna\Messages;

use Omnipay\Klarna\Messages\FetchTransactionRequest;

class FetchTransactionRequestTest extends KlarnaTestCase
{
    /**
     * @var FetchTransactionRequest
     */
    private $request;

    public function setUp(): void
    {
        $this->request = new FetchTransactionRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize($this->getFetchTransactionParams());
    }

    public function testEndpoint(): void
    {
        $orderId = $this->request->getTransactionReference();

        self::assertSame('https://api.playground.klarna.com/ordermanagement/v1/orders/' . $orderId, $this->request->getEndpoint());
    }


    public function testSendSuccess(): void
    {
        $this->setMockHttpResponse('FetchTransactionSuccess.txt');
        $response = $this->request->send();

        self::assertTrue($response->isSuccessful());
    }

    public function testSendError(): void
    {
        $this->setMockHttpResponse('FetchTransactionFailure.txt');
        $response = $this->request->send();

        self::assertFalse($response->isSuccessful());
        self::assertNull($response->getTransactionReference());
        self::assertSame('NO_SUCH_ORDER', $response->getCode());
    }
}
