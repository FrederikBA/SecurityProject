<?php

class User {
    public $uid;
    public $pwd;
    public $pwdRepeat;
    public $username;
    public $email;

    public function __construct($uid, $pwd, $pwdRepeat, $username, $email) {
        $this->uid = $uid;
        $this->pwd = $pwd;
        $this->pwdRepeat = $pwdRepeat;
        $this->username = $username;
        $this->email = $email;
    }
}