<?php

namespace Refactoring\Price;

use Refactoring\Movie;

abstract class Price
{
    public abstract function getPriceCode();

    public abstract function obtainCharge($daysRented);

    /**
     * @param int $daysRented
     * @return int
     */
    public function obtainFrequentRenterPoints($daysRented)
    {
        return 1;
    }
}