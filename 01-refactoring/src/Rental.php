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

    /**
     * @return int
     */
    public function getDaysRented()
    {
        return $this->_daysRented;
    }

    /**
     * @return Movie
     */
    public function getMovie()
    {
        return $this->_movie;
    }

    /**
     * @return float|int
     */
    public function obtainCharge()
    {
        return $this->getMovie()->obtainCharge($this->getDaysRented());
    }

    /**
     * @return int
     */
    public function calculateFrequentRenterPoints()
    {
        return $this->getMovie()->calculateFrequentRenterPoints($this->getDaysRented());
    }
}
