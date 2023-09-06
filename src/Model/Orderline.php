<?php

class Order
{
    public $orderline_id;
    public $order_id;
    public $product_id;
    public $quantity;

    public function __construct($orderline_id, $order_id, $product_id, $quantity)
    {
        $this->$orderline_id = $$orderline_id;
        $this->order_id = $order_id;
        $this->product_id = $product_id;
        $this->quantity = $quantity;
    }
}
