<?php

require_once 'src/Service/ProductService.php';
require_once 'src/Database/Repository/ProductRepository.php';
require_once 'src/Helpers/ValidationHelper.php';

$productRepository = new ProductRepository();
$productService = new ProductService($productRepository);
$validationHelper = new ValidationHelper();

// Get request body
$inputData = file_get_contents("php://input");
$data = json_decode($inputData, true);

if (isset($data['id'], $data['price'])) {

    $validId = $validationHelper->validateIntegerId($data['id']);
    $validPrice = $validationHelper->validatePrice($data['price']);

    if ($validId && $validPrice) {
        $productDto = new UpdateProductDto($data['id'], $data['price']);
        $productService->updateProductPrice($productDto); //Perform update
    }
} else {
    http_response_code(400);
    echo "Invalid body";
}
