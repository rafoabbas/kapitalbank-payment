<?php

namespace Codio\PaymentGateway;

use \Codio\PaymentGateway\Handlers\PaymentGatewayOrderCallbackHandler;

/**
 * Class PaymentGatewayHandlerFactory
 * @package Codio\PaymentGateway
 */
class PaymentGatewayHandlerFactory implements PaymentGatewayHandlerFactoryInterface
{
    /**
     * @return Handlers\PaymentGatewayOrderCallbackHandler
     */
    final public function createOrderCallbackHandler()
    {
        return new PaymentGatewayOrderCallbackHandler();
    }
}