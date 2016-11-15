<?php

namespace Refactoring\Price;

use Refactoring\Movie;

class Children implements Price
{
    public function getPrice()
    {
        return Movie::CHILDRENS;
    }
}