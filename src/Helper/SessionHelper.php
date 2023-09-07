<?php
require_once 'src/Model/Cart.php';
require_once 'src/Service/CartService.php';


class SessionHelper
{

    public function storeCart(Cart $cart)
    {
        if (isset($_SESSION['cart'])) {
            $existingCart = unserialize($_SESSION['cart']);
            $existingCart->updateFrom($cart);
            $_SESSION['cart'] = serialize($existingCart);
        } else {
            // If no cart exists in the session, create a new one.
            $_SESSION['cart'] = serialize($cart);
        }
    }

    public function getCart()
    {
        if (isset($_SESSION['cart'])) {
            return unserialize($_SESSION['cart']);
        } else {
            // return 
        }
    }
}
