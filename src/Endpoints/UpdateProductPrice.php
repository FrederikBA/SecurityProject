<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);


require_once __DIR__ . '/../Service/ProductService.php';

$productService = new ProductService();

// Get the product ID from the route placeholder
$id = isset($parameters['id']) ? intval($parameters['id']) : 0; // Convert $id to integer

// Get the new price from the POST request data
$inputData = file_get_contents("php://input");
$data = json_decode($inputData, true); // Assuming your data is in JSON format

$newPrice = isset($data['new_price']) ? floatval($data['new_price']) : 0.0;

// Update the product price
$productDto = new UpdateProductDto($_POST['id'], $_POST['price']);
$success = $productService->updateProductPriceByID($productDto);

if ($success) {
    header("Content-Type: application/json");
    echo json_encode(array("message" => "Product price updated successfully"));
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Product not found or price couldn't be updated"));
}
?>

<?php

require_once 'src/Service/ProductService.php';

