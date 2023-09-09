<?php
require_once 'src/Service/LoginService.php';
require_once 'src/Database/Repository/UserRepository.php';


if (isset($_POST['username'], $_POST['password'], $_POST['g-recaptcha-response'])) {
    $userRepository = new UserRepository();
    $loginService = new LoginService($userRepository);
    $loginDto = new LoginDto($_POST['username'], $_POST['password'], $_POST['g-recaptcha-response']);
    $loginService->loginUser($loginDto);
} else {
    http_response_code(400);
    echo "Invalid body";
}