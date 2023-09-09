<?php
require_once 'src/Service/LoginService.php';
require_once 'src/Database/Repository/UserRepository.php';
$userRepository = new UserRepository();
$loginService = new LoginService($userRepository);
$loginService->logoutUser();
