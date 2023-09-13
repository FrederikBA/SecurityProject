<?php

class CreateOrderDto
{
    public string $csrf;
    public array $lines;

    public function __construct($csrf, $lines)
    {
        $this->csrf = $csrf;
        $this->lines = $lines;
    }
}
