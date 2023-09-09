<?php

require_once 'src/Service/OrderService.php';
require_once 'src/Database/Repository/OrderRepository.php';

$orderRepository = new orderRepository();
$orderService = new OrderService($orderRepository);

// Get request body
$inputData = file_get_contents("php://input");
$data = json_decode($inputData, true);

if (isset($data['id'])) {
    $dto = new UpdateOrderDto($data['id']);
    $orderService->updateOrderStatus($dto); //Perform update
} else {
    http_response_code(400);
    echo "Invalid body";
}
