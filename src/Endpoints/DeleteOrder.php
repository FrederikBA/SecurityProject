<?php

require_once __DIR__ . '/../Service/OrderService.php';

$orderService = new OrderService();

$inputData = file_get_contents("php://input");
$data = json_decode($inputData, true);



if (isset($data['id'])) {
    $orderDto = new OrderDto($data['id'], ''); 
    $success = $orderService->deleteOrderById($orderDto);

    if ($success) {
        header("Content-Type: application/json");
        echo json_encode(array("message" => "Order deleted successfully"));
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "Order not found or couldn't be deleted"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Missing order ID in request body"));
}
