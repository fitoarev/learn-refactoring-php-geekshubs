<?php

namespace Refactoring\Price;

use Refactoring\Movie;

abstract class Price
{
    public abstract function getPriceCode();

    /**
     * @param int $daysRented
     * @return float
     */
    public function obtainCharge($daysRented)
    {
        $thisAmount = 0;

        switch ($this->getPriceCode()) {
            case Movie::REGULAR:
                $thisAmount += 2;
                if ($daysRented > 2) {
                    $thisAmount += ($daysRented - 2) * 1.5;
                }
                break;
            case Movie::NEW_RELEASE:
                $thisAmount += $daysRented * 3;
                break;
            case Movie::CHILDRENS:
                $thisAmount += 1.5;
                if ($daysRented > 3) {
                    $thisAmount += ($daysRented - 3) * 1.5;
                }
                break;
        }

        return $thisAmount;
    }
}