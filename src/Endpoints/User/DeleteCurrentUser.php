<?php

require_once 'src/Service/UserService.php';
require_once 'src/Database/Repository/UserRepository.php';

// Check if the HTTP method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        $userRepository = new UserRepository();
        $userService = new UserService($userRepository);
        
        // Get the confirmation input from the POST data
        $confirmation = isset($_POST['confirmation']) ? $_POST['confirmation'] : '';
        
        // Check if the user has confirmed deletion
        if ($confirmation === 'I Agree') {
            // Call the deleteCurrentUser function
            $userService->deleteCurrentUser();
        } else {
            // User hasn't confirmed, return an error
            http_response_code(400);
            echo "To delete your account, please type 'I Agree' in the confirmation field.";
        }
    } else {
        // User is not logged in
        http_response_code(401);
        echo "You are not logged in.";
    }
} else {
    // Invalid HTTP method
    http_response_code(405);
    echo "Method not allowed.";
}
