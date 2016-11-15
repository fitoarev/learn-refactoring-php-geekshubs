<?php

namespace Refactoring\Price;

use Refactoring\Movie;

class NewRelease implements Price
{
    public function getPriceCode()
    {
        return Movie::NEW_RELEASE;
    }
}