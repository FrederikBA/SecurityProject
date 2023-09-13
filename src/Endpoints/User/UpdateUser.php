<?php
require_once 'src/Service/UserService.php';
require_once 'src/Database/Repository/UserRepository.php';
require_once 'src/Helpers/ValidationHelper.php';

$userRepository = new UserRepository();
$userService = new UserService($userRepository);
$validationHelper = new ValidationHelper();

// Role protection, admin only
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] !== 2) {
    http_response_code(403);
    echo "Access denied";
    exit;
}

// Get request body
$inputData = file_get_contents("php://input");
$data = json_decode($inputData, true);

if (isset($data['id'], $data['email'], $data['username'])) {
    $validId = $validationHelper->validateIntegerId($data['id']);
    $validEmail = $validationHelper->validateEmail($data['email']);
    $validUsername = $validationHelper->validateUsername($data['username']);

    if ($validId && $validEmail && $validUsername) {
        $userDto = new UserDto($data['id'], $data['email'], $data['username']);
        $userService->updateUser($userDto); //Perform update
    }
} else {
    http_response_code(400);
    echo "Invalid body";
}
