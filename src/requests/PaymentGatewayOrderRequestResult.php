<?php

namespace Codio\PaymentGateway\Requests;

/**
 * Class PaymentGatewayOrderRequestResult
 * @package Codio\PaymentGateway\Requests
 */
class PaymentGatewayOrderRequestResult implements PaymentGatewayRequestResultInterface
{
    private $httpStatus;
    private $responseBody;
    private $status;
    private $data;

    /**
     * PaymentGatewayOrderRequestResult constructor.
     *
     * @param PaymentGatewayHTTPClientResultInterface $HTTPClientResult
     */
    public function __construct(PaymentGatewayHTTPClientResultInterface $HTTPClientResult)
    {
        $this->responseBody = $HTTPClientResult->getOutput();
        $info = $HTTPClientResult->getInfo();
        $this->httpStatus = $info['http_code'];

        if (!$this->responseBody) {
            $this->status = null;
            $this->data = [];
            return;
        }

        $this->data =
            json_decode(
                json_encode(
                    (array)simplexml_load_string($this->responseBody)
                ),
                false
            );

        $response = $this->data->Response;
        $order = $response->Order;
        $this->status = $response->Status;

        $this->data = null;
        if ($this->success()) {
            $this->data = [
                'URL' => $order->URL,
                'OrderId' => $order->OrderID,
                'SessionId' => $order->SessionID,
                'PaymentUrl' => $order->URL . '?' . 'ORDERID=' . $order->OrderID . '&' . 'SESSIONID=' .
                                $order->SessionID
            ];
        }
    }

    public function getHttpStatus()
    {
        return $this->httpStatus;
    }

    final public function getResponseBody()
    {
        $this->responseBody;
    }

    final public function success()
    {
        return $this->status === '00';
    }

    final public function getStatus()
    {
        return $this->status;
    }

    final public function getData()
    {
        return $this->data;
    }
}