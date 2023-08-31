<?php

require_once __DIR__ . '/../Service/UserService.php';

$userService = new UserService();

// Assuming you have a way to get $id, $email, and $username from the request
$id = isset($id) ? intval($id) : 0;
$email = isset($data['email']) ? $data['email'] : '';
$username = isset($data['username']) ? $data['username'] : '';

$userDto = new UserDto($id, $email, $username);

// Delete the user
$success = $userService->deleteUser($userDto);

if ($success) {
    header("Content-Type: application/json");
    echo json_encode(array("message" => "User deleted successfully"));
} else {
    http_response_code(404);
    echo json_encode(array("message" => "User not found or couldn't be deleted"));
}
