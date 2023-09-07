<?php

class Cart
{
    public $cartLines = array();

    public function addCartItem($productId, $productName, $quantity, $price)
    {
        // Check if the product already exists in the cart
        foreach ($this->cartLines as $cartLine) {
            if ($cartLine->getProductId() == $productId) {
                // Update quantity for existing item
                $cartLine->setQuantity($cartLine->getQuantity() + $quantity);
                return;
            }
        }

        // If the product doesn't exist, add a new CartLine
        $cartLine = new CartLine($productId, $productName, $quantity, $price);
        $this->cartLines[] = $cartLine;
    }

    public function removeCartItem($productId)
    {
        // Iterate through cart lines and remove the specified product
        foreach ($this->cartLines as $key => $cartLine) {
            if ($cartLine->getProductId() == $productId) {
                unset($this->cartLines[$key]);
                // Re-index the array to ensure there are no gaps
                $this->cartLines = array_values($this->cartLines);
                return;
            }
        }
    }

    public function updateFrom(Cart $otherCart)
    {
        foreach ($otherCart->getCartLines() as $otherCartLine) {
            $found = false;

            foreach ($this->cartLines as $cartLine) {
                if ($cartLine->getProductId() == $otherCartLine->getProductId()) {
                    $cartLine->setQuantity($otherCartLine->getQuantity());
                    $cartLine->setPrice($otherCartLine->getPrice());
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $this->cartLines[] = $otherCartLine;
            }
        }
    }

    public function getCartLines()
    {
        return $this->cartLines;
    }

    public function clearCart()
    {
        $this->cartLines = array();
    }

    // You can add methods for calculating the total price of the cart, applying discounts, etc.
}
