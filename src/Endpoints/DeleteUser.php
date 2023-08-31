<?php

require_once __DIR__ . '/../Service/UserService.php';

$userService = new UserService();

$inputData = file_get_contents("php://input");
$data = json_decode($inputData, true);

if (isset($data['id'])) {
    $userDto = new UserDto($data['id'], '', ''); // Create UserDto with just the ID
    $success = $userService->deleteUser($userDto);

    if ($success) {
        header("Content-Type: application/json");
        echo json_encode(array("message" => "User deleted successfully"));
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "User not found or couldn't be deleted"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Missing user ID in request body"));
}
