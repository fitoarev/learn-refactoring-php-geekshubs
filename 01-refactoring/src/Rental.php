<?php

namespace Refactoring;

class Rental
{
    private $_movie;
    private $_daysRented;

    public function __construct($movie, $daysRented)
    {
        $this->_movie = $movie;
        $this->_daysRented = $daysRented;
    }

    public function getDaysRented()
    {
        return $this->_daysRented;
    }

    public function getMovie()
    {
        return $this->_movie;
    }

    /**
     * @param $each
     * @return float|int
     */
    public function obtainCharge($each)
    {
        $thisAmount = 0;

        switch ($each->getMovie()->getPriceCode()) {
            case Movie::REGULAR:
                $thisAmount += 2;
                if ($each->getDaysRented() > 2) {
                    $thisAmount += ($each->getDaysRented() - 2) * 1.5;
                }
                break;
            case Movie::NEW_RELEASE:
                $thisAmount += $each->getDaysRented() * 3;
                break;
            case Movie::CHILDRENS:
                $thisAmount += 1.5;
                if ($each->getDaysRented() > 3) {
                    $thisAmount += ($each->getDaysRented() - 3) * 1.5;
                }
                break;

        }
        return $thisAmount;
    }
}
