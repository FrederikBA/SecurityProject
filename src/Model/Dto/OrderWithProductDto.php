<?php

class OrderWithProductDto
{
    public $order_id;
    public $user_id;
    public $product_id;
    public $quantity;
    public $product_name;
    public $product_price;

    public function __construct($order_id, $user_id, $product_id, $quantity, $product_name, $product_price)
    {
        $this->order_id = $order_id;
        $this->user_id = $user_id;
        $this->product_id = $product_id;
        $this->quantity = $quantity;
        $this->product_name = $product_name;
        $this->product_price = $product_price;
    }
}
