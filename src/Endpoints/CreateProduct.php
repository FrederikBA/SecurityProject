<?php

require_once 'src/Service/ProductService.php';

if (isset($_POST['name'], $_POST['price'])) {
    $productRepository = new ProductRepository();
    $productService = new ProductService($productRepository);
    $productDto = new CreateProductDto($_POST['name'], $_POST['price']);
    $productService->createProduct($productDto);
} else {
    http_response_code(400);
    echo "Invalid body";
}
