<?php

require_once 'src/Service/OrderService.php';
require_once 'src/Database/Repository/OrderRepository.php';

$orderRepository = new orderRepository();
$orderService = new orderService($orderRepository);

// Get request body
$inputData = file_get_contents("php://input");
$data = json_decode($inputData, true);

if (isset($data['lines'])) {
    $dto = new CreateOrderDto($data['csrf'], $data['lines']);
    $orderService->createOrder($dto); // Perform create
} else {
    http_response_code(400);
    echo "Invalid body";
}
