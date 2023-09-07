<?php
require_once 'src/Model/Cart.php';
require_once 'src/Model/CartLine.php';


class CartService
{
    private $cart;

    public function __construct()
    {
        $this->cart = new Cart();
    }

    public function addToCart(CartLine $cartLine)
    {
        $this->cart->addCartItem($cartLine->getProductId(), $cartLine->getProductName(), $cartLine->getQuantity(), $cartLine->getPrice());
    }

    public function removeFromCart($productId)
    {
        $this->cart->removeCartItem($productId);
    }

    // public function getCart()
    // {
    //     return $this->cart;
    // }

    public function getCartLines()
    {
        return $this->cart->getCartLines();
    }

    public function clearCart()
    {
        $this->cart->clearCart();
    }

    public function setCart(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function storeCart()
    {
        if (isset($_SESSION['cart'])) {
            $existingCart = unserialize($_SESSION['cart']);
            $existingCart->updateFrom($this->cart);
            $_SESSION['cart'] = serialize($existingCart);
        } else {
            // If no cart exists in the session, create a new one.
            $_SESSION['cart'] = serialize($this->cart);
        }
    }

    public function getCart()
    {
        if (isset($_SESSION['cart'])) {
            return unserialize($_SESSION['cart']);
        } else {
            return $this->cart;
        }
    }

    public function findCartItemById($productId)
    {
        $cart = $this->getCart();
        foreach ($cart->getCartLines() as $cartLine) {
            if ($cartLine->getProductId() == $productId) {
                return $cartLine;
            }
        }
        return null;
    }
}
