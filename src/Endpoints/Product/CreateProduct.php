<?php

require_once 'src/Service/ProductService.php';
require_once 'src/Database/Repository/ProductRepository.php';
require_once 'src/Helpers/ValidationHelper.php';

$productRepository = new ProductRepository();
$productService = new ProductService($productRepository);
$validationHelper = new ValidationHelper();

if (isset($_POST['name'], $_POST['price'])) {

    $validName = $validationHelper->validateProductName($_POST['name']);
    $validPrice = $validationHelper->validatePrice($_POST['price']);

    if ($validName && $validPrice) {
        $productDto = new CreateProductDto($_POST['name'], $_POST['price']);
        $productService->createProduct($productDto);
    }
} else {
    http_response_code(400);
    echo "Invalid body";
}
