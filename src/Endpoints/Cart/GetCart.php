<?php

require_once 'src/Model/Cart.php';
require_once 'src/Model/CartLine.php';
require_once 'src/Service/CartService.php';
require_once 'src/Helper/SessionHelper.php';

// Create a CartService instance
$cartService = new CartService();

// Create a SessionHelper instance
$sessionHelper = new SessionHelper();

// Retrieve the existing cart data from the session
$cart = $sessionHelper->getCart();

//Serialize dto to json and echo
echo json_encode($cart);
