<?php

require_once 'src/Service/ProductService.php';
require_once 'src/Database/Repository/ProductRepository.php';
$productRepository = new ProductRepository();
$productService = new ProductService($productRepository);

$product = $productService->getProduct($id); //id is set automatically because of route setup

//Serialize dto to json and echo
echo json_encode($product);
