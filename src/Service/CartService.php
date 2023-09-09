<?php
require_once 'src/Model/Cart.php';
require_once 'src/Model/CartLine.php';
require_once 'src/Model/Dto/DeleteDto.php';

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

    public function deleteCartItem(DeleteDto $dto)
    {
        $cart = $this->getCart();
        $cartLines = $cart->getCartLines();

        foreach ($cartLines as $key => $cartLine) {
            if ($cartLine->getProductId() == $dto->id) {
                // Remove the CartLine from the array
                unset($cartLines[$key]);

                $cart->setCartLines(array_values($cartLines));

                // Update the total price
                $totalPrice = 0;
                foreach ($cartLines as $line) {
                    $totalPrice += $line->getPrice();
                }
                $cart->setTotalPrice($totalPrice);

                // Store the updated cart in the session
                $_SESSION['cart'] = serialize($cart);

                return true;
            }
        }

        return false;
    }
}
