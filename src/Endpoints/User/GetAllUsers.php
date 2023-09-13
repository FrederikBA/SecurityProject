<?php

require_once 'src/Service/UserService.php';
require_once 'src/Database/Repository/UserRepository.php';
$userRepository = new UserRepository();
$userService = new userService($userRepository);

// Role protection, admin only
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] !== 2) {
    http_response_code(403);
    echo "Access denied";
    exit;
}

$users = $userService->getAllUsers();

//Serialize dto to json and echo
echo json_encode($users);
