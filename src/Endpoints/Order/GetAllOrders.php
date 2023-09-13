<?php
// getUsersHandler.php

require_once 'src/Service/OrderService.php';
require_once 'src/Database/Repository/OrderRepository.php';
$orderRepository = new OrderRepository();
$orderService = new OrderService($orderRepository);

// Role protection, admin only
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] !== 2) {
    http_response_code(403);
    echo "Access denied";
    exit;
}

$orders = $orderService->getAllOrders();

//Serialize dto to json and echo
echo json_encode($orders);
