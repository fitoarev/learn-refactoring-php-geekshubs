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

    public function find(int $ft): PersonPair
    {
        /** @var PersonPair[] $personPairList */
        $personPairList = [];

        for ($i = 0; $i < count($this->_personList); $i++) {
            for ($j = $i + 1; $j < count($this->_personList); $j++) {
                $aPersonPair = new PersonPair();

                if ($this->_personList[$i]->birthDate < $this->_personList[$j]->birthDate) {
                    $aPersonPair->person1 = $this->_personList[$i];
                    $aPersonPair->person2 = $this->_personList[$j];
                } else {
                    $aPersonPair->person1 = $this->_personList[$j];
                    $aPersonPair->person2 = $this->_personList[$i];
                }

                $aPersonPair->distanceBetweenBirthdays = $aPersonPair->person2->birthDate->getTimestamp()
                    - $aPersonPair->person1->birthDate->getTimestamp();

                $personPairList[] = $aPersonPair;
            }
        }

        if (count($personPairList) < 1) {
            return new PersonPair();
        }

        $answer = $personPairList[0];

        foreach ($personPairList as $result) {
            switch ($ft) {
                case FT::ONE:
                    if ($result->distanceBetweenBirthdays < $answer->distanceBetweenBirthdays) {
                        $answer = $result;
                    }
                    break;

                case FT::TWO:
                    if ($result->distanceBetweenBirthdays > $answer->distanceBetweenBirthdays) {
                        $answer = $result;
                    }
                    break;
            }
        }

        return $answer;
    }
}
