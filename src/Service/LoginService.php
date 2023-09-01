<?php
require_once 'src/Database/Connector.php';
require_once 'src/Model/Dto/RegisterDto.php';

class LoginService extends Connector
{
    public function registerUser($registerDto)
    {
        try {
            // Get the database connection using the parent class's getConnection method
            $connection = $this->getConnection();

            // Hash the password
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

            return ["success" => true, "message" => "Registration successful"];
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                // Handle duplicate key violation (username already exists)
                return ["success" => false, "error" => "Username already exists."];
            } else {
                // Handle other database errors
                return ["success" => false, "error" => "Registration failed: " . $e->getMessage()];
            }
        }
    }
}