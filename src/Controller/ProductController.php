<?php

require_once 'src/Service/ProductService.php';

#public function create() {
if (isset($_POST['name'], $_POST['price'], $_POST['img'])) {
    $productService = new ProductService();
    $product = new Product($_POST['name'], $_POST['price'], $_POST['img']);
    $productService->createProduct($product);
    echo "Product created successfully!";
} else {
    echo "Failed to create product!";
}
#}

