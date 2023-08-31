<?php

require_once __DIR__ . '/../Service/ProductService.php';

$productService = new ProductService();

// Get the product ID from the URL
$id = isset($id) ? intval($id) : 0; // Convert $id to integer

$product = $productService->getProductByID($id);

if ($product) {
    header("Content-Type: application/json");
    echo json_encode($product);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Product not found"));
}
?>

