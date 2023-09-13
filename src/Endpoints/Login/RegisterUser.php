<?php
require_once 'src/Service/LoginService.php';
require_once 'src/Database/Repository/UserRepository.php';
require_once 'src/Helpers/ValidationHelper.php';

$userRepository = new UserRepository();
$loginService = new LoginService($userRepository);
$validationHelper = new ValidationHelper();

if (isset($_POST['email'], $_POST['username'], $_POST['password'])) {
    $validEmail = $validationHelper->validateEmail($_POST['email']);
    $validUsername = $validationHelper->validateUsername($_POST['username']);

    if ($validEmail && $validUsername) {
        $registerDto = new RegisterDto($_POST['email'], $_POST['username'], $_POST['password']);
        $loginService->registerUser($registerDto);
    }
} else {
    http_response_code(400);
    echo "Invalid body";
}
