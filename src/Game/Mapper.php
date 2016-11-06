<?php

namespace Contest\Game;

class Mapper {

    /**
     * @var array
     */
    private static $cardsValues = null;

    /**
     * @return array
     */
    public static function getCardsValues() {
        if (self::$cardsValues == null) {
            self::$cardsValues =  [
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                '5' => 5,
                '6' => 6,
                '7' => 7,
                '8' => 8,
                '9' => 9,
                '10'=> 10,
                'J' => 11,
                'Q' => 12,
                'K' => 13,
                'A' => 14
            ];
        }

        return self::$cardsValues;
    }
}
