<?php

namespace Codio\PaymentGateway\Requests;

/**
 * Interface PaymentGatewayRequestResultInterface
 * @package Codio\PaymentGateway\Requests
 */
interface PaymentGatewayRequestResultInterface
{
    /**
     * PaymentGatewayRequestResultInterface constructor.
     *
     * @param PaymentGatewayHTTPClientResultInterface $HTTPClientResult
     */
    public function __construct(PaymentGatewayHTTPClientResultInterface $HTTPClientResult);

    /**
     * Returns http status
     *
     * @return integer
     */
    public function getHttpStatus();

    /**
     * Returns raw response body
     *
     * @return mixed
     */
    public function getResponseBody();

    /**
     * Returns true if request is successful
     *
     * @return bool
     */
    public function success();

    /**
     * Returns request processing status
     *
     * @return mixed
     */
    public function getStatus();

    /**
     * Returns usable structure from processing of response body
     *
     * @return mixed
     */
    public function getData();
}