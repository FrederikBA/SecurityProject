<?php
require_once 'src/Service/LoginService.php';

if (isset($_POST['username'], $_POST['password'])) {
    $loginService = new LoginService();
    $loginDto = new LoginDto($_POST['username'], $_POST['password']);
    $loginService->loginUser($loginDto);
} else {
    http_response_code(400);
    echo "Invalid body";
}
