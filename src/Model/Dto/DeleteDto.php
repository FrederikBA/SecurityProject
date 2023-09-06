<?php

class DeleteDto // Generic Dto
{
    public $id;


    public function __construct($id)
    {
        $this->id = $id;
    }
}
