<?php
require_once 'src/Database/Connector.php';

class UserRepository extends Connector
{
    public function updateUser(int $userId, string $email, string $username)
    {
        $sql = "UPDATE user SET email = :newEmail, username = :newUsername WHERE user_id = :userId";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':newEmail', $email);
        $stmt->bindParam(':newUsername', $username);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function getUser(int $userId)
    {
        $sql = "SELECT user_id, email, username FROM user WHERE user_id = :userId";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    public function getAllUsers()
    {
        $sql = "SELECT * FROM user";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function deleteUser($userId)
    {
        $sql = "DELETE FROM user WHERE user_id = :userId";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function createUser(string $email, string $username, string $password)
    {
        $connection = $this->getConnection();

        $stmt = $connection->prepare("INSERT INTO User (email, username, password) VALUES (?, ?, ?)");
        $stmt->execute([$email, $username, $password]);

        $user_id = $connection->lastInsertId();

        $stmt = $connection->prepare("INSERT INTO UserRole (user_id, role_id) VALUES (?, ?)");
        $stmt->execute([$user_id, 1]); // roleId 1 = user role
    }

    public function getUserLoginCredentials(string $username)
    {
        $connection = $this->getConnection();

        $stmt = $connection->prepare(
            "SELECT User.user_id, User.password, UserRole.role_id FROM User
            INNER JOIN UserRole ON User.user_id = UserRole.user_id WHERE User.username = ?"
        );
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
}

