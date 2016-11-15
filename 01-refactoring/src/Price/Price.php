<?php

namespace Refactoring\Price;

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