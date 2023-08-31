<?php

class UserDto {
    public $id;
    public $email;
    public $name;


    public function __construct($id,  $email, $name,) {
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;

    }
}


