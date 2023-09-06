<?php

class UserDto
{
    public $id;
    public $email;
    public $username;


    public function __construct($id,  $email, $username,)
    {
        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
    }
}
