<?php

namespace Refactoring;

class Customer
{
    private $_name;
    private $_rentals = array();

    public function __construct($name)
    {
        $this->_name = $name;
    }

    public function addRental(Rental $arg)
    {
        $this->_rentals[] = $arg;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function statement()
    {
        $result = "Rental Record for " . $this->getName() . "\n";

        foreach ($this->_rentals as $rental) {
            $result .= "\t" . $rental->getMovie()->getTitle() . "\t" . $rental->obtainCharge() . "\n";
        }

        $result .= "Amount owed is " . $this->calculateTotalAmount($this->_rentals) . "\n";
        $result .= "You earned " . $this->calculateTotalFrequentPoints($this->_rentals) . " frequent renter points";

        return $result;
    }

    /**
     * @param Rental[] $rentals
     * @return float
     */
    private function calculateTotalFrequentPoints($rentals)
    {
        $frequentRenterPoints = 0;

        foreach ($rentals as $rental) {
            $frequentRenterPoints = $frequentRenterPoints +
                $rental->calculateFrequentRenterPoints();
        }

        return $frequentRenterPoints;
    }

    /**
     * @param Rental[] $rentals
     * @return float
     */
    private function calculateTotalAmount($rentals)
    {
        $totalAmount = 0;

        foreach ($rentals as $rental) {
            $totalAmount = $totalAmount + $rental->obtainCharge();
        }

        return $totalAmount;
    }
}
