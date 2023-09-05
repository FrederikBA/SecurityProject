<?php

require_once __DIR__ . '/../Service/UserService.php';
require_once 'src/Database/Repository/UserRepository.php';
$userRepository = new UserRepository();
$userService = new UserService($userRepository);

// Get request body
$inputData = file_get_contents("php://input");
$data = json_decode($inputData, true);

if (isset($data['id'])) {
    $userDto = new UserDto($data['id'], '', ''); // Create UserDto with just the ID
    $userService->deleteUser($userDto); // Perform delete
} else {
    http_response_code(400);
    echo "Invalid body";
}
