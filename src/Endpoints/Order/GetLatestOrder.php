<?php

require_once 'src/Service/OrderService.php';
require_once 'src/Database/Repository/OrderRepository.php';
$orderRepository = new OrderRepository();
$orderService = new OrderService($orderRepository);

$order = $orderService->getLatestOrder(); //id is set automatically because of route setup

//Serialize dto to json and echo
if ($order) {
    echo json_encode($order);
}
