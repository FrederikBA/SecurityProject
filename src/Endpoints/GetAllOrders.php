<?php
// getUsersHandler.php

require_once 'src/Service/OrderService.php';
require_once 'src/Database/Repository/OrderRepository.php';
$orderRepository = new OrderRepository();
$orderService = new OrderService($orderRepository);

$orders = $orderService->getAllOrders();

//Serialize dto to json and echo
echo json_encode($orders);
