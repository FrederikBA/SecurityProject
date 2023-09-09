<?php

class CreateOrderDto
{
    public array $lines;

    public function __construct($lines)
    {
        $this->lines = $lines;
    }
}
