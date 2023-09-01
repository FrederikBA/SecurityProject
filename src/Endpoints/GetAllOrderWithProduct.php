<?php
// getUsersHandler.php

require_once 'src/Service/OrderService.php'; 

$orderService = new OrderService();

$orders = $orderService->getAllOrdersWithDetails();

// Set the appropriate Content-Type header
header("Content-Type: application/json");

// Output the fetched orders as JSON
echo json_encode($orders);
?>
