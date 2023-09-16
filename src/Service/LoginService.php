<?php
require_once 'src/Database/Repository/UserRepository.php';
require_once 'src/Model/Dto/RegisterDto.php';
require_once 'src/Model/Dto/LoginDto.php';
require 'vendor/autoload.php';

use Dotenv\Dotenv;

class LoginService
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
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
                $logMessage = "[" . date("d.m.Y H:i:s") . "] " . $e->getMessage() .  "\n";
                error_log($logMessage, 3, 'logs/servererror.log');
            }
        }
    }

    public function loginUser($loginDto)
    {
        try {
            $recaptchaResponse = $loginDto->recaptchaResponse;
            if (!$this->recaptchaVerification($recaptchaResponse)) {
                return;
            }

            // Get and check user credentials from the database
            $user = $this->userRepository->GetUserLoginCredentials($loginDto->username);

            if ($user && password_verify($loginDto->password, $user['password'])) {

                // Password is correct, create the session variables for the user
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role_id'] = $user['role_id'];

                //Create session variables for the CSRF token on login
                $csrfToken = bin2hex(random_bytes(32));
                $_SESSION['csrf_token'] = $csrfToken;

                // Regenerate the session ID each login
                session_regenerate_id(true);

                echo "Login successful";
            } else {
                http_response_code(401);
                echo "Incorrect username or password";
                $logMessage = "[" . date("d.m.Y H:i:s") . "] Incorrect login attempt for user: " . $loginDto->username .  "\n";
                error_log($logMessage, 3, 'logs/userlogin.log');
            }
        } catch (PDOException $e) {
            http_response_code(500);
            // Handle database errors
            $logMessage = "[" . date("d.m.Y H:i:s") . "] " . $e->getMessage() .  "\n";
            error_log($logMessage, 3, 'logs/servererror.log');
        }
    }


    private function recaptchaVerification(string $recaptchaResponse)
    {
        // Verify CAPTCHA first
        $secret = $_ENV['CAPTCHA_KEY'];
        $response = $recaptchaResponse;
        $remoteip = $_SERVER['REMOTE_ADDR'];

        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip";
        $responseData = file_get_contents($url);
        $dataRow = json_decode($responseData, true);

        if ($dataRow['success']) {
            return true;
        } else {
            http_response_code(401);
            echo "reCAPTCHA verification failed";
            return false;
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

                echo "You have been logged out.";
            } else {
                http_response_code(500);
                echo "You are not logged in.";
            }
        } catch (Exception $e) {
            http_response_code(500);
            $logMessage = "[" . date("d.m.Y H:i:s") . "] " . $e->getMessage() .  "\n";
            error_log($logMessage, 3, 'logs/servererror.log');
        }
    }

    // Checks the PHP session if user_id is available (is logged in)
    public function checkLoginStatus()
    {
        if (isset($_SESSION['user_id'])) {
            // User is logged in, check if user exists in the database
            $this->userRepository->getUser($_SESSION['user_id']);

            switch ($this->checkRole()) {
                case "user":
                    // User with role "user" is logged in
                    return "user";

                case "admin":
                    // User with role "admin" is logged in
                    return "admin";

                default:
                    // User is not found in the database, consider them logged out
                    unset($_SESSION['user_id']);
                    http_response_code(401);
                    echo json_encode(["message" => "User is not logged in"]);
                    break;
            }
        } else {
            // User is not logged in
            http_response_code(401);
            echo json_encode(["message" => "User is not logged in"]);
        }
    }


    private function checkRole()
    {
        if (isset($_SESSION['role_id'])) {
            $role = $_SESSION['role_id'];
            if ($role === 1) {
                return "user";
            } elseif ($role === 2) {
                return "admin";
            } else {
                return "unknown";
            }
        }
    }
}
