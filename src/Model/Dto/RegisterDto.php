<?php

class RegisterDto
{
    public $email;
    public $username;
    public $password;


    public function __construct($email, $username, $password)
    {
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
    }
}
