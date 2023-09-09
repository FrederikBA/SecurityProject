<?php

require_once 'src/Model/Cart.php';
require_once 'src/Model/CartLine.php';
require_once 'src/Service/CartService.php';

$cartService = new CartService();

$cart = $cartService->getCart();

//Serialize dto to json and echo
echo json_encode($cart);
