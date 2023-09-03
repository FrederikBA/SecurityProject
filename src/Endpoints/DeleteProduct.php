<?php

require_once __DIR__ . '/../Service/ProductService.php';

$productService = new ProductService();

$inputData = file_get_contents("php://input");
$data = json_decode($inputData, true);



if (isset($data['id'])) {
    $productDto = new UpdateProductDto($data['id'], ''); 
    $success = $productService->deleteProductByID($productDto);

    if ($success) {
        header("Content-Type: application/json");
        echo json_encode(array("message" => "Product deleted successfully"));
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "Product not found or couldn't be deleted"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Missing product ID in request body"));
}
