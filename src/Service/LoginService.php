<?php
require_once 'src/Database/Repository/UserRepository.php';
require_once 'src/Model/Dto/RegisterDto.php';
require_once 'src/Model/Dto/LoginDto.php';
//require_once 'LoggingManager.php';

class LoginService
{
    private $userRepository;
    private $securityLogger;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        //$securityLoggerManager = new LoggingManager('security', 'Logs/security.log');
       // $this->securityLogger = $securityLoggerManager->getLogger();
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
            // Verify CAPTCHA first
            $secret = '6LcPegcoAAAAADplYg5YG4dUtZu_E9d1DrA9jESF'; // replace with your secret key
            $response = $loginDto->recaptchaResponse;
            $remoteip = $_SERVER['REMOTE_ADDR'];
    
            $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip";
            $responseData = file_get_contents($url);
            $dataRow = json_decode($responseData, true);
    
            

            if (!$dataRow['success']) {
                http_response_code(401);
              //  $this->securityLogger->error('reCAPTCHA verification failed');
                echo "reCAPTCHA verification failed";
                return;
            }

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
                //Captcha skal være korrekt men pass/user forkert, før den rammer her.
                $logMessage = "[" . date("d.m.Y H:i:s") . "] Incorrect login attempt for user: " . $loginDto->username .  "\n";
                error_log($logMessage, 3, 'logs/userlogin.log');
                echo "Incorrect username or password";
            }
        } catch (PDOException $e) {
            http_response_code(500);
            $logMessage = "[" . date("d.m.Y H:i:s") . "] Database error: " . $e->getMessage();
            error_log($logMessage, 3, 'logs/userlogin.log');
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
        if (isset($_SESSION['user_id'])) {
            echo json_encode(["message" => "User is logged in"]);
        } else {
            // User is not logged in
            http_response_code(401);
            echo json_encode(["message" => "User is not logged in"]);
        }
    }
}

