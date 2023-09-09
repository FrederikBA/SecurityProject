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
        $cart = isset($_SESSION['cart']) ? unserialize($_SESSION['cart']) : $this->cart;

        // Calculate the total price
        $totalPrice = 0;
        foreach ($cart->getCartLines() as $cartLine) {
            $totalPrice += $cartLine->getPrice();
        }

        $cart->setTotalPrice($totalPrice);

        return $cart;
    }

    public function addToCart(CartLine $line)
    {
        $cartLine = new CartLine($line->getProductId(), $line->getProductName(), $line->getQuantity(), $line->getPrice());
        $this->cart->cartLines[] = $cartLine;
    }

    public function clearCart()
    {
        $this->cart->cartLines = array();
        // Clear from session
        if (isset($_SESSION['cart'])) {
            unset($_SESSION['cart']);
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

    public function removeCartItem($productId)
    {
        foreach ($this->cart->cartLines as $key => $cartLine) {
            if ($cartLine->getProductId() == $productId) {
                unset($this->cart->cartLines[$key]);
                $this->cart->cartLines = array_values($this->cart->cartLines);
                return;
            }
        }
    }
}
