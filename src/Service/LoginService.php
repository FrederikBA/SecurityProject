<?php
require_once 'src/Database/Connector.php';
require_once 'src/Model/Dto/RegisterDto.php';
require_once 'src/Model/Dto/LoginDto.php';

class LoginService extends Connector
{
    public function registerUser($registerDto)
    {
        try {
            // Get the database connection
            $connection = $this->getConnection();

            // Hash the password (password_hash uses the bcrypt algorithm)
            $hashedPassword = password_hash($registerDto->password, PASSWORD_DEFAULT);

            // Set the default role to 'user' on register (other roles are set differently)
            $roleId = 1; // 1 = user role

            // Insert user data into the User table
            $stmt = $connection->prepare("INSERT INTO User (email, username, password) VALUES (?, ?, ?)");
            $stmt->execute([$registerDto->email, $registerDto->username, $hashedPassword]);

            // Get the user_id of the newly inserted user
            $user_id = $connection->lastInsertId();

            // Insert the user role into the UserRole table
            $stmt = $connection->prepare("INSERT INTO UserRole (user_id, role_id) VALUES (?, ?)");
            $stmt->execute([$user_id, $roleId]);

            echo "Registration successful";
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                // Handle duplicate key violation (username already exists)
                echo "Username already exists: " . $e->getMessage();
            } else {
                // Handle other database errors
                echo "Registration failed<: " . $e->getMessage();
            }
        }
    }
    
    public function loginUser($loginDto)
    {
        try {
            // Get the database connection
            $connection = $this->getConnection();

            // Retrieve the user's hashed password and role from the database
            $stmt = $connection->prepare("SELECT User.user_id, User.password, UserRole.role_id FROM User
                                           INNER JOIN UserRole ON User.user_id = UserRole.user_id
                                           WHERE User.username = ?");
            $stmt->execute([$loginDto->username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($loginDto->password, $user['password'])) {
                // Password is correct, create a session for the user
                session_start();
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role_id'] = $user['role_id'];

                echo "Login successful";
            } else {
                echo "Incorrect username or password";
            }
        } catch (PDOException $e) {
            // Handle database errors
            echo "Login failed: " . $e->getMessage();
        }
    }
}
