<?php

namespace Refactoring\Price;

use Refactoring\Movie;

class Children implements Price
{
    public function getPriceCode()
    {
        return Movie::CHILDRENS;
    }
}