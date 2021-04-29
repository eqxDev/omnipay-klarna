<?php
/**
 * Klarna Refund Request
 */

namespace Omnipay\Klarna\Messages;

use Exception;

class RefundRequest extends AbstractRequest
{
    /**
     * @return array|mixed
     * @throws Exception
     */
    public function getData(): array
    {
        $data = ['refunded_amount' => $this->getAmountInteger()];

        $this->setRequestParams($data);

        return $data;
    }

    /**
     * @return string
     */
    public function getProcessType(): string
    {
        return 'refund';
    }

    /**
     * @return array
     */
    public function getSensitiveData(): array
    {
        return [];
    }

    /**
     * @return string
     */
    public function getProcessName(): string
    {
        return 'Refund';
    }

    /**
     * @return string
    */
    public function getEndpoint() : string
    {
        return parent::getEndpoint() . '/ordermanagement/v1/orders/'.$this->getTransactionReference().'/refunds';
    }

    /**
     * @param $data
     * @return RefundResponse
     */
    protected function createResponse($data): RefundResponse
    {
        $response = new RefundResponse($this, $data);
        $requestParams = $this->getRequestParams();
        $response->setServiceRequestParams($requestParams);

        return $response;
    }
}
