<?php
require_once 'src/Database/Connector.php';

class UserRepository extends Connector //Implement interface 
{
    public function createUser(string $email, string $username, string $password)
    {
        $connection = $this->getConnection();

        $stmt = $connection->prepare("INSERT INTO User (email, username, password) VALUES (?, ?, ?)");
        $stmt->execute([$email, $username, $password]);

        $user_id = $connection->lastInsertId();

        $stmt = $connection->prepare("INSERT INTO UserRole (user_id, role_id) VALUES (?, ?)");
        $stmt->execute([$user_id, 1]); // roleId 1 = user role
    }

    public function GetUserLoginCredentials(string $username)
    {
        // Get the database connection
        $connection = $this->getConnection();

        // Retrieve the user's hashed password and role from the database
        $stmt = $connection->prepare("SELECT User.user_id, User.password, UserRole.role_id FROM User
                                               INNER JOIN UserRole ON User.user_id = UserRole.user_id
                                               WHERE User.username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
}
