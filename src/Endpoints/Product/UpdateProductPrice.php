<?php

require_once 'src/Service/ProductService.php';
require_once 'src/Database/Repository/ProductRepository.php';
$productRepository = new ProductRepository();
$productService = new ProductService($productRepository);

// Get request body
$inputData = file_get_contents("php://input");
$data = json_decode($inputData, true);

if (isset($data['id'], $data['price'])) {
    $productDto = new UpdateProductDto($data['id'], $data['price']);
    $productService->updateProductPrice($productDto); //Perform update
} else {
    http_response_code(400);
    echo "Invalid body";
}
