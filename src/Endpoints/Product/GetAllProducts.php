<?php

require_once 'src/Service/ProductService.php';
require_once 'src/Database/Repository/ProductRepository.php';
$productRepository = new ProductRepository();
$productService = new ProductService($productRepository);

$products = $productService->getAllProducts();

//Serialize dto to json and echo
echo json_encode($products);
