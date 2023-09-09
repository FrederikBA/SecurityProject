<?php
require_once 'src/Service/LoginService.php';
require_once 'src/Database/Repository/UserRepository.php';

if (isset($_POST['email'], $_POST['username'], $_POST['password'])) {
    $userRepository = new UserRepository();
    $loginService = new LoginService($userRepository);
    $registerDto = new RegisterDto($_POST['email'], $_POST['username'], $_POST['password']);
    $loginService->registerUser($registerDto);
} else {
    http_response_code(400);
    echo "Invalid body";
}
