<?php

declare(strict_types = 1);

namespace CodelyTV\FinderKata\Algorithm;

final class Finder
{
    /** @var Person[] */
    private $_personList;

    public function __construct(array $personList)
    {
        $this->_personList = $personList;
    }

    public function find(int $ft): F
    {
        /** @var F[] $tr */
        $tr = [];

        for ($i = 0; $i < count($this->_personList); $i++) {
            for ($j = $i + 1; $j < count($this->_personList); $j++) {
                $r = new F();

                if ($this->_personList[$i]->birthDate < $this->_personList[$j]->birthDate) {
                    $r->p1 = $this->_personList[$i];
                    $r->p2 = $this->_personList[$j];
                } else {
                    $r->p1 = $this->_personList[$j];
                    $r->p2 = $this->_personList[$i];
                }

                $r->d = $r->p2->birthDate->getTimestamp()
                    - $r->p1->birthDate->getTimestamp();

                $tr[] = $r;
            }
        }

        if (count($tr) < 1) {
            return new F();
        }

        $answer = $tr[0];

        foreach ($tr as $result) {
            switch ($ft) {
                case FT::ONE:
                    if ($result->d < $answer->d) {
                        $answer = $result;
                    }
                    break;

                case FT::TWO:
                    if ($result->d > $answer->d) {
                        $answer = $result;
                    }
                    break;
            }
        }

        return $answer;
    }
}
