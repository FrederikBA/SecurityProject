<?php

class Order
{
    public $order_id;
    public $user_id;

    public function __construct($order_id, $user_id)
    {
        $this->order_id = $order_id;
        $this->user_id = $user_id;
    }
}
