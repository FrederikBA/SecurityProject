<?php

class UpdateOrderDto
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}
