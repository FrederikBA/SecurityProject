<?php

require_once 'src/Service/OrderService.php';
require_once 'src/Database/Repository/OrderRepository.php';
$orderRepository = new orderRepository();
$orderService = new orderService($orderRepository);

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
    $dto = new DeleteDto($data['id']);
    $orderService->deleteOrder($dto); // Perform delete
} else {
    http_response_code(400);
    echo "Invalid body";
}
