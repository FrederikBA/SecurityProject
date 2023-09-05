<?php

require_once 'src/Service/ProductService.php';

if (isset($_POST['name'], $_POST['price'])) {
    $productService = new ProductService();
    
    $productDto = new CreateProductDto($_POST['name'], $_POST['price']);
    $productService->createProduct($productDto);
} else {
    echo "Invalid body";
}
