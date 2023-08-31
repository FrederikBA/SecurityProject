<?php

class Signup extends Connector 
{
    
    protected function setUser($uid, $pwd, $email)
    {
        $resultCheck;

        $stmt = $this->getConnection()->prepare('INSERT INTO userlogin (username, password) VALUES (?,?,?)');

        if (!$stmt->execute(arra($uid, $email))) 
        {
            // If the statement fails we want to set it to null, to not execute the rest of it.
            $stmt = null;
            header("location: ../../public/index.php?error=stmtfailed");
            exit();
        }

        if ($stmt->rowCount() > 0) 
        {
            //Here we check if anything is returned from the database,.
            $resultCheck = false;
        }
        else 
        {
            $resultCheck = true;
        }
    }

    protected function checkUser($uid, $email)
    {
        $resultCheck;

        //$stmt = $this->getConnection()->prepare('SELECT username FROM userlogin WHERE username = ?');
        //$stmt = $this->getConnection()->prepare('SELECT email FROM user WHERE email = ?');

        // With join instead.
        $stmt = $this->getConnection()->prepare('SELECT u.email, ul.username FROM user AS u LEFT JOIN userlogin AS ul ON u.user_id = ul.user_id WHERE u.email = ? OR ul.username = ?');

        if (!$stmt->execute(arra($uid, $email))) 
        {
            // If the statement fails we want to set it to null, to not execute the rest of it.
            $stmt = null;
            header("location: ../../public/index.php?error=stmtfailed");
            exit();
        }

        if ($stmt->rowCount() > 0) 
        {
            //Here we check if anything is returned from the database,.
            $resultCheck = false;
        }
        else 
        {
            $resultCheck = true;
        }
    }

}
