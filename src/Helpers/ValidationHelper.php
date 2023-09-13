<?php

class ValidationHelper
{
    public function validateEmail($emailInput)
    {
        //Sanitize and validate email input 
        $email = filter_var($emailInput, FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo $email . ' is not a valid email address';
            http_response_code(400);
        } else {
            return $email;
        }
    }

    public function validateUsername($usernameInput)
    {
        //Sanitize and validate username input 
        $username = filter_var(trim($usernameInput), FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($username)) {
            echo 'Username cannot be empty';
            http_response_code(400);
        } else {
            if (preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
                return $username;
            } else {
                echo $username . ' is not a valid username';
                http_response_code(400);
            }
        }
    }

    public function validateIntegerId($integerInput)
    {
        //Sanitize and validate id integer input
        $integer = filter_var($integerInput, FILTER_SANITIZE_NUMBER_INT);
        if (!filter_var($integer, FILTER_VALIDATE_INT)) {
            echo 'Not a valid id';
            http_response_code(400);
        } else {
            return $integer;
        }
    }

    public function validateProductName($nameInput)
    {
        //Sanitize and validate product name input 
        $name = filter_var($nameInput, FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($name)) {
            echo 'Name cannot be empty';
            http_response_code(400);
        } else {
            if (preg_match('/^[a-zA-Z0-9_\s]+$/', $name)) {
                return $name;
            } else {
                echo $name . ' is not a valid product name';
                http_response_code(400);
            }
        }
    }

    public function validatePrice($priceInput)
    {
        //Sanitize and validate float input
        $float = filter_var($priceInput, FILTER_SANITIZE_NUMBER_FLOAT);
        if (!filter_var($float, FILTER_VALIDATE_FLOAT)) {
            echo 'Not a valid price';
            http_response_code(400);
        } else {
            return $float;
        }
    }
}
