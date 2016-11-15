<?php

namespace Refactoring\Price;

use Refactoring\Movie;

class Children extends Price
{
    public function getPriceCode()
    {
        return Movie::CHILDRENS;
    }

    /**
     * @param int $daysRented
     * @return float
     */
    public function obtainCharge($daysRented)
    {
        $amount = 1.5;
        if ($daysRented > 3) {
            $amount = $amount + ($daysRented - 3) * 1.5;
        }

        return $amount;
    }
}