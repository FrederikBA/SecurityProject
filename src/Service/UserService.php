<?php

require_once 'src/Database/Connector.php';
require_once 'src/Model/Dto/UserDto.php';

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function updateUserInfo(UserDto $userDto)
    {
        try {
            $updatedUser = $this->userRepository->UpdateUser($userDto->id, $userDto->email, $userDto->username);
            if ($updatedUser > 0) {
                echo "User updated successfully";
                return $updatedUser;
            } else {
                echo "Error updating User";
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo "Unexpected error, update failed";
        }
    }


    public function getUserById($userID)
    {
        try {
            $user = $this->userRepository->GetUser($userID);
            if ($user) {
                return new UserDto($user['user_id'], $user['email'], $user['username']);
            } else {
                return "User not found";
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo $e;
        }
    }

    public function deleteUser(UserDto $userDto)
    {
        try {
            $rowsDeleted = $this->userRepository->DeleteUser($userDto->id);
            if ($rowsDeleted > 0) {
                echo "User deleted successfully";
                return $rowsDeleted;
            } else {
                echo "User not found or couldn't be deleted";
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo $e;
        }
    }
}
