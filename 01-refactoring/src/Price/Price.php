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
        $frequentRenterPoints = 1;
        if (($this->getPriceCode() == Movie::NEW_RELEASE)
            &&
            $daysRented > 1
        ) {
            $frequentRenterPoints = $frequentRenterPoints + 1;
        }
        return $frequentRenterPoints;
    }
}