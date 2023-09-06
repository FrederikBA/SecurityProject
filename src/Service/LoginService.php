<?php
require_once 'src/Database/Repository/UserRepository.php';
require_once 'src/Model/Dto/RegisterDto.php';
require_once 'src/Model/Dto/LoginDto.php';

class LoginService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function registerUser($registerDto)
    {
        try {
            // Hash the password (password_hash uses the bcrypt algorithm)
            $hashedPassword = password_hash($registerDto->password, PASSWORD_DEFAULT);

            // Create user in database
            $this->userRepository->createUser($registerDto->email, $registerDto->username, $hashedPassword);

            echo "Registration successful";
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                // Handle duplicate key violation (username already exists)
                http_response_code(500);
                echo "Username already exists";
            } else {
                http_response_code(500);
                echo $e->getMessage();
            }
        }
    }

    public function loginUser($loginDto)
    {
        try {
            // Get and check user credentials from the database
            $user = $this->userRepository->GetUserLoginCredentials($loginDto->username);

            if ($user && password_verify($loginDto->password, $user['password'])) {

                // Password is correct, create a session for the user
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role_id'] = $user['role_id'];

                // Regenerate the session ID and delete the old one on each login
                session_regenerate_id(true);

                echo "Login successful";
            } else {
                http_response_code(500);
                echo "Incorrect username or password";
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo $e->getMessage();
        }
    }


    public function logoutUser()
    {
        try {
            // Check if the user is logged in
            if (isset($_SESSION['user_id'])) {
                // Destroy the session and unset all session variables. Prevents user information being accessed
                // by anyone who may use the same device after the user has logged out.
                session_unset();
                session_destroy();

                echo "Logout successful";
            } else {
                http_response_code(500);
                echo "You are not logged in.";
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo $e->getMessage();
        }
    }

    // Checks the PHP session if user_id is available (is logged in)
    public function checkLoginStatus()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            echo json_encode(["message" => "User is logged in"]);
        } else {
            // User is not logged in
            http_response_code(401);
            echo json_encode(["message" => "User is not logged in"]);
        }
    }
}
