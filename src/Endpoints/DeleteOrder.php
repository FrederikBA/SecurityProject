<?php

require_once 'src/Service/OrderService.php';
require_once 'src/Database/Repository/OrderRepository.php';
$orderRepository = new orderRepository();
$orderService = new orderService($orderRepository);

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
