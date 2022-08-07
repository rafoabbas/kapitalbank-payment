<?php

namespace Codio\PaymentGateway\Requests;

/**
 * Interface PaymentGatewayHTTPClientResultInterface
 * @package Codio\PaymentGateway\Requests
 */
interface PaymentGatewayHTTPClientResultInterface
{
    public function __construct($output, $info);

    /**
     * Returns request info (headers, status and etc)
     *
     * @return mixed
     */
    public function getInfo();

    /**
     * Returns raw http output
     *
     * @return mixed
     */
    public function getOutput();
}