<?php

namespace Refactoring\Price;

use Refactoring\Movie;

class Children extends Price
{
    public function getPriceCode()
    {
        return Movie::CHILDRENS;
    }
}