<?php

require_once 'src/Service/CartService.php';
$cartService = new CartService();

// Get request body
$inputData = file_get_contents("php://input");
$data = json_decode($inputData, true);

if (isset($data['id'])) {
    $dto = new DeleteDto($data['id']);
    $cartService->deleteCartItem($dto); // Perform delete
} else {
    http_response_code(400);
    echo "Invalid body";
}
