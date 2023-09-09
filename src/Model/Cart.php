<?php

class Cart
{
    public $cartLines = array();
    public $totalPrice = 0;

    public function getCartLines()
    {
        return $this->cartLines;
    }

    public function setCartLines($cartLines)
    {
        $this->cartLines = $cartLines;
    }

    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
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
}
