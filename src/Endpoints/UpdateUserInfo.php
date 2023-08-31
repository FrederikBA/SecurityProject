<?php


require_once __DIR__ . '/../Service/UserService.php';

$userService = new UserService();

// Get the product ID from the route placeholder
$id = isset($parameters['id']) ? intval($parameters['id']) : 0; // Convert $id to integer

// Get the new price from the POST request data
$inputData = file_get_contents("php://input");
$data = json_decode($inputData, true); // Assuming your data is in JSON format

$newEmail = isset($data['new_email']) ? floatval($data['new_email']) : "";

// Update the product price
$userDto = new UserDto($_POST['id'], $_POST['email'], $_POST['name']);
$success = $userService->updateUserInfo($userDto);

if ($success) {
    header("Content-Type: application/json");
    echo json_encode(array("message" => "User info updated successfully"));
} else {
    http_response_code(404);
    echo json_encode(array("message" => "User not found or couldn't be updated"));
}
?>

<?php

require_once 'src/Service/ProductService.php';

