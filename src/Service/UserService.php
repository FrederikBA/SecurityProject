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
                http_response_code(500);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            $logMessage = "[" . date("d.m.Y H:i:s") . "] " . $e->getMessage() .  "\n";
            error_log($logMessage, 3, 'logs/servererror.log');
        }
    }


    public function getUserById($userID)
    {
        try {
            $user = $this->userRepository->GetUser($userID);
            if ($user) {
                return new UserDto($user['user_id'], $user['email'], $user['username']);
            } else {
                http_response_code(404);
                return "User not found";
            }
        } catch (PDOException $e) {
            http_response_code(500);
            $logMessage = "[" . date("d.m.Y H:i:s") . "] " . $e->getMessage() .  "\n";
            error_log($logMessage, 3, 'logs/servererror.log');
        }
    }

    public function getAllUsers()
    {
        try {
            $products = $this->userRepository->getAllUsers();
            return $products;
        } catch (PDOException $e) {
            http_response_code(500);
            $logMessage = "[" . date("d.m.Y H:i:s") . "] " . $e->getMessage() .  "\n";
            error_log($logMessage, 3, 'logs/servererror.log');
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
                echo "User not found";
                http_response_code(404);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            $logMessage = "[" . date("d.m.Y H:i:s") . "] " . $e->getMessage() .  "\n";
            error_log($logMessage, 3, 'logs/servererror.log');
        }
    }


    public function deleteCurrentUser()
    {
        try {
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];
            $rowsDeleted = $this->userRepository->deleteUser($userId);
            
            if (isset($_POST['confirmation']) && $_POST['confirmation'] === 'I Agree') {
            
            $rowsDeleted = $this->userRepository->deleteUser($userId);
            
            if ($rowsDeleted > 0) {
                echo "User deleted successfully";
                return $rowsDeleted;
            } else {
                // User not found
                http_response_code(404);
                echo "User not deleted";
            }
        } else {
            // User hasn't confirmed the deletion
            echo "To delete your account, please type 'I Agree' in the confirmation field.";
        }
    } else {
        // User is not logged in or found
        echo "User not logged in or found";
        http_response_code(404);
    }
    } catch (PDOException $e) {
            http_response_code(500);
            $logMessage = "[" . date("d.m.Y H:i:s") . "] " . $e->getMessage() .  "\n";
            error_log($logMessage, 3, 'logs/servererror.log');
        }
    }


}
