<?php

require_once 'src/Database/Connector.php';
require_once 'src/Model/user.php';
require_once 'src/Model/Dto/UserDto.php';

/* "bindParam" - Binding Parameters: You're using parameter binding to safely insert the values into the query. This helps prevent SQL injection. */

class UserService extends Connector
{

    
    public function updateUserInfo(UserDto $userDto) {
        $sql = "UPDATE user SET email = :newEmail, username = :newUserame WHERE user_id = :userID";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':userID', $userDto->id);
        $stmt->bindParam(':newEmail', $userDto->email);
        $stmt->bindParam(':newUserame', $userDto->username);
        // Check if the update was successful
        return $stmt->execute();
    }
    
    
    public function getUserById($userID) {
        $sql = "SELECT `user_id`, `email`, `username` FROM `user` WHERE user_id = :userID";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user;
    }

    


}