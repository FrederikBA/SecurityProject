<?php

require_once 'src/Service/ProductService.php';
require_once 'src/Database/Repository/ProductRepository.php';
$productRepository = new ProductRepository();
$productService = new ProductService($productRepository);

$inputData = file_get_contents("php://input");
$data = json_decode($inputData, true);

// Get request body
$inputData = file_get_contents("php://input");
$data = json_decode($inputData, true);

if (isset($data['id'])) {
    $dto = new DeleteDto($data['id']);
    $productService->deleteProduct($dto); // Perform delete
} else {
    http_response_code(400);
    echo "Invalid body";
}
