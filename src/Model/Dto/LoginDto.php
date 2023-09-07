<?php

class LoginDto {
    public $username;
    public $password;
    public $recaptchaResponse;

    public function __construct($username, $password, $recaptchaResponse) {
        $this->username = $username;
        $this->password = $password;
        $this->recaptchaResponse = $recaptchaResponse;
    }
}
