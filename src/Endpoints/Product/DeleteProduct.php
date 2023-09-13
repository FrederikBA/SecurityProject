<?php

require_once 'src/Service/ProductService.php';
require_once 'src/Database/Repository/ProductRepository.php';
require_once 'src/Helpers/ValidationHelper.php';

$productRepository = new ProductRepository();
$productService = new ProductService($productRepository);
$validationHelper = new ValidationHelper();

$inputData = file_get_contents("php://input");
$data = json_decode($inputData, true);

// Get request body
$inputData = file_get_contents("php://input");
$data = json_decode($inputData, true);

if (isset($data['id'])) {
    $validId = $validationHelper->validateIntegerId($data['id']);

    if ($validId) {
        $dto = new DeleteDto($data['id']);
        $productService->deleteProduct($dto); // Perform delete
    }
} else {
    http_response_code(400);
    echo "Invalid body";
}
