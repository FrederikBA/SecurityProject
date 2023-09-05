<?php

require_once __DIR__ . '/../Service/UserService.php';
require_once 'src/Database/Repository/UserRepository.php';
$userRepository = new UserRepository();
$userService = new UserService($userRepository);

$foundUser = $userService->getUserById($id);

//Serialize dto to json and echo
echo json_encode($foundUser);
