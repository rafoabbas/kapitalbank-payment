<?php

namespace Codio\PaymentGateway;

use \Codio\PaymentGateway\Handlers\PaymentGatewayHandlerInterface;

/**
 * Interface PaymentGatewayHandlerFactoryInterface
 * @package Codio\PaymentGateway
 */
interface PaymentGatewayHandlerFactoryInterface
{
    /**
     * Returns a new instance of PaymentGatewayHandlerInterface
     * that will handle callbacks after order creation
     *
     * @return PaymentGatewayHandlerInterface
     */
    public function createOrderCallbackHandler();
}