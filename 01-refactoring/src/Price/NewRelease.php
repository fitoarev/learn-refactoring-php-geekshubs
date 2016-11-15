<?php

namespace Refactoring\Price;

use Refactoring\Movie;

class NewRelease implements Price
{
    public function getPrice()
    {
        return Movie::NEW_RELEASE;
    }
}