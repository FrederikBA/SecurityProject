<?php

class OrderDto
{
    public $id;
    public $userId;

    public function __construct($id, $userId)
    {
        $this->id = $id;
        $this->userId = $userId;
    }
}
