<?php
require_once 'src/Service/LoginService.php';

if (isset($_POST['username'], $_POST['password'])) {
    $loginService = new LoginService();
    $loginDto = new LoginDto($_POST['username'], $_POST['password']);
    $loginService->loginUser($loginDto);
} else {
    echo "Invalid body";
}
