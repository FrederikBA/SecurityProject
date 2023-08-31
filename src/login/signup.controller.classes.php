<?php

class SignupController {
    
    //Disse variables er private fordi SignupController er den eneste class der skal have adgang til dem.
    private $uid;
    private $pwd;
    private $pwdRepeat;
    private $email;

    public function __construct($uid, $pwd, $pwdRepeat, $email) 
    {
        $this->uid =$uid;
        $this->pwd =$pwd;
        $this->pwdRepeat =$pwdRepeat;
        $this->email =$email;
    }

    // All functionality that fx. checks if username is acceptable and that pwd and repeat pwd is the same goes below here.

    private function emptyInput()
    {
        $results;
        if (empty($this->uid) || empty($this->pwd) || empty($this->pwdRepeat) || empty($this->email)) 
        {
            $results = false;
        }
        else
        {
            $results = true;
        }
        return $results;
    }

    private function invalidUid() 
    {
        $results;
        if (!preg_match("/^[a-zA-Z0-9]*$/", $this->uid)) 
        {
            $results = false;
        }
        else
        {
            $results = true;
        }
        return $results;
    }

    private function invalidEmail()
    {
        $results;
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) 
        {
            $results = false;
        }
        else
        {
            $results = true;
        }
        return $results;
    }

    private function pwdMatch()
    {
        $results;
        if ($this->pwd !== $this->pwdRepeat) 
        {
            $results = false;
        }
        else
        {
            $results = true;
        }
        return $results;
    }
}
