<?php
require_once 'src/Service/LoginService.php';
require_once 'src/Database/Repository/UserRepository.php';
require_once 'src/Helpers/ValidationHelper.php';

$userRepository = new UserRepository();
$loginService = new LoginService($userRepository);
$validationHelper = new ValidationHelper();

if (isset($_POST['username'], $_POST['password'], $_POST['g-recaptcha-response'])) {

    $validUsername = $validationHelper->validateUsername($_POST['username']);

    if ($validUsername) {
        $loginDto = new LoginDto($_POST['username'], $_POST['password'], $_POST['g-recaptcha-response']);
        $loginService->loginUser($loginDto);
    }
} else {
    http_response_code(400);
    echo "Invalid body";
}
