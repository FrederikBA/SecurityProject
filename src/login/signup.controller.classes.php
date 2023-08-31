<?php

class SignupController extends signupUser
{
    
    //Disse variables er private fordi SignupController er den eneste class der skal have adgang til dem.
    private $uid;
    private $pwd;
    private $pwdRepeat;
    private $email;
    private $name;

    public function __construct($uid, $pwd, $pwdRepeat, $email, $name) 
    {
        $this->uid =$uid;
        $this->pwd =$pwd;
        $this->pwdRepeat =$pwdRepeat;
        $this->email =$email;
        $this->name =$name;
    }

    public function signupUser()
    {
        if ($this->emptyInput() == false) 
        {
            // echo "Empty input fields!";
            header("location: ../../public/index.php?error=emptyInput");
            exit();
        }
        if ($this->invalidUid() == false) 
        {
            // echo "Invalid Username!";
            header("location: ../../public/index.php?error=invalidUid");
            exit();
        }
        if ($this->invalidEmail() == false) 
        {
            // echo "Invalid Email!";
            header("location: ../../public/index.php?error=invalidEmail");
            exit();
        }
        if ($this->pwdMatch() == false) 
        {
            // echo "Passwords don't match!";
            header("location: ../../public/index.php?error=pwdMatch");
            exit();
        }
        if ($this->uidTakenCheck() == false) 
        {
            // echo "Username or Email is taken!";
            header("location: ../../public/index.php?error=uidTaken");
            exit();
        }

        $this->setUser($this->uid, $this->pwd, $this->name, $this->email);
    }

    // All functionality that fx. checks if username is acceptable and that pwd and repeat pwd is the same goes below here.

    private function emptyInput()
    {
        $results;
        if (empty($this->uid) || empty($this->pwd) || empty($this->pwdRepeat) || empty($this->name) || empty($this->email)) 
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

    private function uidTakenCheck()
    {
        $results;
        if (!$this->checkUser($this->uid, $this->email)) 
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
