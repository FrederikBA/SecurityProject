<?php

require_once 'src/Service/CartService.php';
require_once 'src/Model/CartLine.php';
$cartService = new CartService();

if (isset($_POST['product_id'], $_POST['product_name'], $_POST['quantity'], $_POST['product_price'])) {
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $quantity = (int)$_POST['quantity'];
    $product_price = (float)$_POST['product_price'];

    $cart = $cartService->getCart();

    // Check if the product already exists in the cart
    $existingCartItem = $cartService->findCartItemById($productId);

    if ($existingCartItem) {
        // If the product exists, update its quantity
        $existingCartItem->setQuantity($existingCartItem->getQuantity() + $quantity);
        $price = $existingCartItem->quantity * $product_price;
        $cartLine = new CartLine($existingCartItem->productId, $existingCartItem->productName, $existingCartItem->quantity, $price);
        $cartService->addToCart($cartLine);
    } else {
        // If the product doesn't exist, create a new CartLine
        $price = $product_price * $quantity;
        $cartLine = new CartLine($productId, $productName, $quantity, $price);
        $cartService->addToCart($cartLine);
    }


    // Store the updated cart back in the session
    $cartService->storeCart($cart);
} else {
    http_response_code(400);
    echo "Invalid body";
}
