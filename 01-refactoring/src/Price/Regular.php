<?php

namespace Refactoring\Price;

use Refactoring\Movie;

class Regular extends Price
{
    public function getPriceCode()
    {
        return Movie::REGULAR;
    }
}