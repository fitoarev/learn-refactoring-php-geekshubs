<?php

namespace Refactoring;

use Refactoring\Price\Children;
use Refactoring\Price\NewRelease;
use Refactoring\Price\Price;
use Refactoring\Price\Regular;

class Movie
{
    const CHILDRENS = 2;
    const REGULAR = 0;
    const NEW_RELEASE = 1;
    private $_title;
    /**
     * @var Price
     */
    private $_price;

    public function __construct($title, $priceCode)
    {
        $this->_title = $title;
        $this->setPrice($priceCode);
    }

    public function getPriceCode()
    {
        return $this->_price->getPriceCode();
    }

    public function setPriceCode($arg)
    {
        $this->_price = $arg;
    }

    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * @param int $daysRented
     * @return float
     */
    public function obtainCharge($daysRented)
    {
        return $this->_price->obtainCharge($daysRented);
    }

    /**
     * @return int
     */
    public function calculateFrequentRenterPoints($daysRented)
    {
        return 1 + $this->addBonusPoints($daysRented);
    }

    /**
     * @return int
     */
    public function addBonusPoints($daysRented)
    {
        $frequentRenterPoints = 0;
        if (($this->getPriceCode() == Movie::NEW_RELEASE)
            &&
            $daysRented > 1
        ) {
            $frequentRenterPoints = $frequentRenterPoints + 1;
        }
        return $frequentRenterPoints;
    }

    private function setPrice($priceCode)
    {
        switch ($priceCode) {
            case self::REGULAR:
                $this->_price = new Regular();
                break;
            case self::NEW_RELEASE:
                $this->_price = new NewRelease();
                break;
            case self::CHILDRENS:
                $this->_price = new Children();
                break;
        }
    }
}
