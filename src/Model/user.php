<?php

class User {
    public $uid;
    public $pwd;
    public $pwdRepeat;
    public $name;
    public $email;

    public function __construct($uid, $pwd, $pwdRepeat, $name, $email) {
        $this->uid = $uid;
        $this->pwd = $pwd;
        $this->pwdRepeat = $pwdRepeat;
        $this->name = $name;
        $this->email = $email;
    }
}
