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

// Get request body
$inputData = file_get_contents("php://input");
$data = json_decode($inputData, true);

if (isset($data['id'])) {
    $dto = new UpdateOrderDto($data['id']);
    $orderService->updateOrderStatus($dto); // Perform update
} else {
    http_response_code(400);
    echo "Invalid body";
}
