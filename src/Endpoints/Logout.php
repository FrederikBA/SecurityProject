<?php
require_once 'src/Service/LoginService.php';
    $loginService = new LoginService();
    $loginService->logoutUser();
