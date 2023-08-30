<?php
// getUsersHandler.php

require_once 'src/Service/ProductService.php'; // Include the ProductService.php file

// Create an instance of the ProductService class
$productService = new ProductService();

// Fetch products from the database using the ProductService function
$products = $productService->getProductsFromDatabase();

// Set the appropriate Content-Type header
header("Content-Type: application/json");

// Output the fetched products as JSON
echo json_encode($products);
?>
