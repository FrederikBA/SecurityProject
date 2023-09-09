<?php
require_once 'src/Service/CartService.php';

$cartService = new CartService();

$cartService->clearCart();
