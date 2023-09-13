<?php

class DeleteCurrentDto // Generic Dto
{
    public $confirmation;


    public function __construct($confirmation)
    {
        $this->confirmation = $confirmation;
    }
}
