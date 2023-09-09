<?php
require_once 'src/Service/LoginService.php';
require_once 'src/Database/Repository/UserRepository.php';
$userRepository = new UserRepository();
$loginService = new LoginService($userRepository);
$userRole = $loginService->checkLoginStatus();

//Serialize dto to json and echo
if ($userRole) {
    echo json_encode($userRole);
}
