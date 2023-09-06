<?php
require_once 'src/Service/UserService.php';
require_once 'src/Database/Repository/UserRepository.php';
$userRepository = new UserRepository();
$userService = new UserService($userRepository);

// Get request body
$inputData = file_get_contents("php://input");
$data = json_decode($inputData, true);

if (isset($data['id'], $data['email'], $data['username'])) {
    $userDto = new UserDto($data['id'], $data['email'], $data['username']); // Create UserDto with just the ID
    $userService->updateUser($userDto); //Perform update
} else {
    http_response_code(400);
    echo "Invalid body";
}
