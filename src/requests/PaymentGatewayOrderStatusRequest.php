<?php

namespace Codio\PaymentGateway\Requests;

use \Codio\PaymentGateway\Requests\PaymentGatewayRequestSettings as RequestSettings;

/**
 * Class PaymentGatewayOrderStatusRequest
 * @package Codio\PaymentGateway\Requests
 */
class PaymentGatewayOrderStatusRequest implements PaymentGatewayRequestInterface
{
    use RequestSettings;

    private $requestAttributes = [];
    private $debugToFile = null;

    /**
     * PaymentGatewayOrderStatusRequest constructor.
     *
     * @param string $merchantId
     * @param string $requestUrl
     * @param string $orderId
     * @param string $sessionId
     * @param string $lang
     */
    public function __construct($requestUrl, $merchantId, $orderId, $sessionId, $lang = 'EN', $debugToFile)
    {
        $this->requestAttributes =
            compact('merchantId', 'requestUrl', 'orderId', 'sessionId', 'lang');
        $this->debugToFile = $debugToFile;
    }

    public function execute()
    {
        $ssl = [
            'key' => $this->sslKey,
            'keyPass' => $this->sslKeyPass,
            'cert' => $this->sslCertificate
        ];
        $httpClient =
            new PaymentGatewayHTTPClient($this->requestAttributes['requestUrl'], $this->getRequestBody(), $ssl, $this->strictSSL);
        if ($this->debugToFile) {
            $httpClient->setDebugToFile($this->debugToFile);
        }
        return new PaymentGatewayOrderStatusRequestResult($httpClient->execute());
    }

    final private function getRequestBody()
    {
        $templateFile = __DIR__ . '/templates/OrderStatusRequestBodyTemplate.xml';
        $body = file_get_contents($templateFile);
        foreach ($this->requestAttributes AS $key => $value) {
            $body = str_replace('{{' . $key . '}}', $value, $body);
        }
        return $body;
    }
}