<?php
require_once('vendor/autoload.php');

use \Codio\PaymentGateway\PaymentGatewayHandlerFactory;

$handlerFactory = new PaymentGatewayHandlerFactory();
$orderCallbackHandler = $handlerFactory->createOrderCallbackHandler();

$orderStatusData = $orderCallbackHandler->handle();

var_dump($orderStatusData);
