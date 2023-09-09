<?php

require_once 'src/Model/Dto/UserDto.php';
require_once 'src/Model/Dto/DeleteDto.php';


class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function updateUser(UserDto $userDto)
    {
        try {
            $updatedUser = $this->userRepository->UpdateUser($userDto->id, $userDto->email, $userDto->username);
            if ($updatedUser > 0) {
                echo "User updated successfully";
                return $updatedUser;
            } else {
                echo "An error occured updating User";
                //TODO Statuscode
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo $e->getMessage();
            //TODO log $e->getMessage()
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
                //TODO Statuscode
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo $e->getMessage();
            //TODO log $e->getMessage()
        }
    }

    public function deleteUser(DeleteDto $dto)
    {
        try {
            $rowsDeleted = $this->userRepository->DeleteUser($dto->id);
            if ($rowsDeleted > 0) {
                echo "User deleted successfully";
                return $rowsDeleted;
            } else {
                echo "User not found or couldn't be deleted";
                //TODO Statuscode
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo $e->getMessage();
            //TODO log $e->getMessage()
        }
    }
}
