<?php

require_once 'src/Service/UserService.php';
require_once 'src/Database/Repository/UserRepository.php';
$userRepository = new UserRepository();
$userService = new UserService($userRepository);

// Get request body
$inputData = file_get_contents("php://input");
$data = json_decode($inputData, true);

if (isset($data['id'])) {
    $dto = new DeleteDto($data['id']);
    $userService->deleteUser($dto); // Perform delete
} else {
    http_response_code(400);
    echo "Invalid body";
}