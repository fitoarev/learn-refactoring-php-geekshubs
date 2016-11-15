<?php

namespace Refactoring\Price;

use Refactoring\Movie;

class Regular implements Price
{
    public function getPrice()
    {
        return Movie::REGULAR;
    }
}