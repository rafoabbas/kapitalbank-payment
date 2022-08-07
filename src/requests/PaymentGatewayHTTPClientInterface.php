<?php

namespace Codio\PaymentGateway\Requests;

/**
 * Interface PaymentGatewayHTTPClientInterface
 * @package Codio\PaymentGateway\Requests
 */
interface PaymentGatewayHTTPClientInterface
{
    /**
     * PaymentGatewayHTTPClientInterface constructor.
     *
     * @param string $url
     * @param null   $body
     * @param null   $sslCertificate
     * @param bool $strictSSL
     */
    public function __construct($url, $body = null, $sslCertificate = null, $strictSSL = true);

    /**
     * @param string $path_to_file
     * @return void
     */
    public function setDebugToFile($path_to_file);

    /**
     * @return PaymentGatewayHTTPClientResultInterface
     */
    public function execute();
}