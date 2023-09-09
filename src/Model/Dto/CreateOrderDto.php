<?php

class CreateOrderDto
{
    public string $id;
    public array $lines;

    public function __construct($id, $lines)
    {
        $this->id = $id;
        $this->lines = $lines;
    }
}
