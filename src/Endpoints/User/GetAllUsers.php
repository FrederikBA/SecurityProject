<?php

require_once 'src/Service/UserService.php';
require_once 'src/Database/Repository/UserRepository.php';
$userRepository = new UserRepository();
$userService = new userService($userRepository);

$users = $userService->getAllUsers();

//Serialize dto to json and echo
echo json_encode($users);
