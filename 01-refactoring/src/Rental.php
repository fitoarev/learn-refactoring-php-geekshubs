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
     * @return float|int
     */
    public function obtainCharge()
    {
        $thisAmount = 0;

        switch ($this->getMovie()->getPriceCode()) {
            case Movie::REGULAR:
                $thisAmount += 2;
                if ($this->getDaysRented() > 2) {
                    $thisAmount += ($this->getDaysRented() - 2) * 1.5;
                }
                break;
            case Movie::NEW_RELEASE:
                $thisAmount += $this->getDaysRented() * 3;
                break;
            case Movie::CHILDRENS:
                $thisAmount += 1.5;
                if ($this->getDaysRented() > 3) {
                    $thisAmount += ($this->getDaysRented() - 3) * 1.5;
                }
                break;

        }
        return $thisAmount;
    }

    /**
     * @return int
     */
    public function calculateFrequentRenterPoints()
    {
        $frequentRenterPoints = 1;
        $frequentRenterPoints = $frequentRenterPoints + $this->addBonusForNewRelease();

        return $frequentRenterPoints;
    }

    /**
     * @return int
     */
    private function addBonusForNewRelease()
    {
        $frequentRenterPoints = 0;
        if (($this->getMovie()->getPriceCode() == Movie::NEW_RELEASE)
            &&
            $this->getDaysRented() > 1
        ) {
            $frequentRenterPoints = $frequentRenterPoints + 1;
            return $frequentRenterPoints;
        }
        return $frequentRenterPoints;
    }
}
