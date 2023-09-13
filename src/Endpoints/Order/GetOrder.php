<?php

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

$order = $orderService->getOrder($id); //id is set automatically because of route setup

//Serialize dto to json and echo
if ($order) {
    echo json_encode($order);
}
