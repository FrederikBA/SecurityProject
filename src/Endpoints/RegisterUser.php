<?php
require_once 'src/Service/LoginService.php';

if (isset($_POST['email'], $_POST['username'], $_POST['password'])) {
    $loginService = new LoginService();
    $registerDto = new RegisterDto($_POST['email'], $_POST['username'], $_POST['password']);
    $loginService->registerUser($registerDto);
} else {
    http_response_code(400);
    echo "Invalid body";
}
