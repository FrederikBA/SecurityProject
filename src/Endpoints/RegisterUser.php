<?php
require_once 'src/Service/LoginService.php';

if (isset($_POST['email'], $_POST['username'], $_POST['password'])) {
    $loginService = new LoginService();
    $registerDto = new RegisterDto($_POST['email'], $_POST['username'], $_POST['password']);
    $loginService->registerUser($registerDto);
    echo "200 OK";
} else {
    echo "Error occured";
}
