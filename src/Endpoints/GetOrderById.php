<?php
// getUsersHandler.php

require_once 'src/Service/OrderService.php'; 

$orderService = new OrderService();

$order = $orderService->getOrderById($id);

// Set the appropriate Content-Type header
header("Content-Type: application/json");

// Output the fetched order as JSON
echo json_encode($order);
?>
