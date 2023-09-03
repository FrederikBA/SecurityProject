<?php

require_once __DIR__ . '/../Service/UserService.php';

$userService = new UserService();

$id = isset($id) ? intval($id) : 0; // Convert $id to integer

$user = $userService->getUserById($id);

if ($user) {
    header("Content-Type: application/json");
    echo json_encode($user);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "User not found"));
}
?>

