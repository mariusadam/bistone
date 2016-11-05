<?php
class Constants {

    public static function getCardsValues() {
        return [
            "1"=>1,
            "2"=>2,
            "3"=>3,
            "4"=>4,
            "5"=>5,
            "6"=>6,
            "7"=>7,
            "8"=>8,
            "9"=>9,
            "10"=>10,
            "J"=>11,
            "Q"=>12,
            "K"=>13,
            "A"=>14
        ];
    }
}

class Rules {
    const DRAW = 'DRAW';
    const FIRST = 'A';
    const SECOND = 'B';

    const NONE = 0;
    const PAIR = 1;
    const THREE_OF_A_KIND = 2;
    const STRAIGHT = 3;
    const FLUSH = 4;
    const FULL = 5;
    const FOUR = 6;
    const STRAIGHT_FLUSH = 10;

    public static function getRules()
    {
        return [
            self::NONE => function(Player $p1, Player $p2) {
                $s1 = $p1->getCodesSum();
                $s2 = $p2->getCodesSum();

                if ($s1 == $s2) {
                    return self::DRAW;
                } elseif ($s1 > $s2) {
                    return self::FIRST;
                } else return self::SECOND;
            },
            self::PAIR => function(Player $p1, Player $p2) {
                $c1 = $p1->hasTwoOfAKind($p1->getCodes());
                $c2 = $p2->hasTwoOfAKind($p2->getCodes());

//                echo " ";
//                print_r($c1);
//                echo " asdasd ";
//                print_r($c2);
//                die;

                if ($c1 == $c2) {
                    return self::DRAW;
                } elseif ($c1 > $c2) {
                    return self::FIRST;
                } else return self::SECOND;
            },

            self::THREE_OF_A_KIND => function(Player $p1, Player $p2) {
                $c1 = $p1->hasThreeOfAKind($p1->getCodes());
                $c2 = $p2->hasThreeOfAKind($p2->getCodes());
                if ($c1 == $c2) {
                    return self::DRAW;
                } elseif ($c1 > $c2) {
                    return self::FIRST;
                } else return self::SECOND;
            },

            self::STRAIGHT => function(Player $p1, Player $p2) {
                $c1 = max($p1->getCodes());
                $c2 = max($p2->getCodes());
                if ($c1 == $c2) {
                    return self::DRAW;
                } elseif ($c1 > $c2) {
                    return self::FIRST;
                } else return self::SECOND;
            },

            self::FLUSH => function(Player $p1, Player $p2) {
                $c1 = max($p1->getCodes());
                $c2 = max($p2->getCodes());
                if ($c1 == $c2) {
                    return self::DRAW;
                } elseif ($c1 > $c2) {
                    return self::FIRST;
                } else return self::SECOND;
            },

            self::FULL => function(Player $p1, Player $p2) {
                $c1 = $p1->getCodesSum();
                $c2 = $p2->getCodesSum();
                if ($c1 == $c2) {
                    return self::DRAW;
                } elseif ($c1 > $c2) {
                    return self::FIRST;
                } else return self::SECOND;
            },

//            self::FOUR => function(Player $p1, Player $p2) {
//                $c1 = $p1->hasFourOfAKind($p1->getCodes());
//                $c2 = $p2->hasFourOfAKind($p2->getCodes());
//                if ($c1 == $c2) {
//                    return self::DRAW;
//                } elseif ($c1 > $c2) {
//                    return self::FIRST;
//                } else return self::SECOND;
//            },

            self::STRAIGHT_FLUSH => function(Player $p1, Player $p2) {
                $c1 = max($p1->getCodes());
                $c2 = max($p2->getCodes());
                if ($c1 == $c2) {
                    return self::DRAW;
                } elseif ($c1 > $c2) {
                    return self::FIRST;
                } else return self::SECOND;
            },
        ];
    }
}



class Player {
    private $cards;

    private $codes;
    private $colours;
    public function __construct(array $cards)
    {
        $this->cards = $cards;
    }

    /**
     * @return array
     */
    public function getCards()
    {
        return $this->cards;
    }

    public function getHandType()
    {
        $decoded = [];
        foreach ($this->cards as $card) {
            $decoded[] = [
                'code' => Constants::getCardsValues()[$this->getCode($card)],
                'colour' => $this->getColour($card),
            ];
        }

        $codes = array_column($decoded, 'code');
        $colors = array_column($decoded, 'colour');
        $this->setCodes($codes);
        $this->setColours($colors);

//        print_r($codes);
//        print_r($colors);
        if ($this->isConsecutive($codes) && $this->isHomogenous($colors)) {
            print_r(Rules::STRAIGHT_FLUSH);
            return Rules::STRAIGHT_FLUSH;
        }

        if ($this->hasFourOfAKind($codes) !== false) {
            print_r(Rules::FOUR);
            return Rules::FOUR;
        }

        if ($this->has3And2($codes)) {
            print_r(Rules::FULL);
            return Rules::FULL;
        }

        if ($this->isHomogenous($colors)) {
            print_r(Rules::FLUSH);
            return Rules::FLUSH;
        }

        if ($this->isConsecutive($codes)) {
            print_r(Rules::STRAIGHT);
            return Rules::STRAIGHT;
        }

        if ($this->hasThreeOfAKind($codes)) {
            print_r(Rules::THREE_OF_A_KIND);
            return Rules::THREE_OF_A_KIND;
        }

        if ($this->hasTwoOfAKind($codes)) {
            print_r(Rules::PAIR);
            return Rules::PAIR;

        }

        print_r(Rules::NONE);
        return Rules::NONE;
    }

    /**
     * @param array $cards
     */
    public function setCards($cards)
    {
        $this->cards = $cards;
    }

    public function isHomogenous($arr) {
        $firstValue = current($arr);
        foreach ($arr as $val) {
            if ($firstValue !== $val) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return mixed
     */
    public function getCodes()
    {
        return $this->codes;
    }

    /**
     * @param mixed $codes
     */
    public function setCodes($codes)
    {
        $this->codes = $codes;
    }

    /**
     * @return mixed
     */
    public function getColours()
    {
        return $this->colours;
    }

    /**
     * @param mixed $colours
     */
    public function setColours($colours)
    {
        $this->colours = $colours;
    }

    public function isConsecutive($array) {
        $set = array_unique($array);

        if (count($set) != count($array)) {
            return false;
        }

        return ((int)max($array)-(int)min($array) == (count($array)-1));
    }

    public function getColour($string) {
        return substr($string, -1);
    }

    public function getCode($string) {
        $c = substr($string, 0, strlen($string) -1);
//        if ($c === 0) {
//            die($c);
//        }

        return (string) $c;
    }

    public function getFrequency(array $array, $elem)
    {
        $count = 0;
        foreach ($array as $value) {
            if ($value == $elem) {
                $count++;
            }
        }

        return $count;
    }

    public function hasFourOfAKind(array $array) {
        foreach ($array as $value) {
            if ($this->getFrequency($array, $value) == 4) {
                return $value;
            }
        }

        return false;
    }

    public function hasThreeOfAKind(array $array) {
        foreach ($array as $value) {
            if ($this->getFrequency($array, $value) == 3) {
                return $value;
            }
        }

        return false;
    }

    public function hasTwoOfAKind(array $array) {
        $value1 = -1;
        foreach ($array as $value) {
            if ($this->getFrequency($array, $value) == 2) {
                if ($value1 < $value) {
                    $value1 = $value;
                };
            }
        }

        if ($value1 != -1) {
            return $value1;
        }

        return false;
    }

    public function has3And2(array $array) {
        $set = array_values(array_unique($array));
        if (count($set) != 2) {
            return false;
        }

        $f1 = $this->getFrequency($array, $set[0]);
        $f2 = $this->getFrequency($array, $set[1]);

        if ($f1 == 2 && $f2 == 3) {
            return true;
        }

        if ($f1 == 3 && $f2 == 2) {
            return true;
        }

        return false;
    }

    public function getCodesSum() {
        $sum = 0;
        foreach ($this->codes as $code) {
            $sum += $code;
        }

        return $sum;
    }
}

$file = file_get_contents('files/1.txt');

$lines = explode("\n", $file);

$player1 = new Player([]);
$player2 = new Player([]);

$fp = fopen('files/out.txt', 'w');

foreach ($lines as $line) {

    $array = explode(' ', $line);

//    print_r($array);continue;

    $player1->setCards([
        $array[0],
        $array[1],
        $array[4],
        $array[5],
        $array[6],
    ]);
    $player2->setCards([
        $array[2],
        $array[3],
        $array[4],
        $array[5],
        $array[6],
    ]);

    $hand1 = $player1->getHandType();
    $hand2 = $player2->getHandType();

    //print_r($hand1);
    //print_r($hand2);

    if ($hand1 > $hand2) {
        echo " A";
        fprintf($fp, "%s\n", Rules::FIRST);
    } elseif ($hand2 > $hand1) {
        echo " B";
        fprintf($fp, "%s\n", Rules::SECOND);
    } else {
        $res = Rules::getRules()[$hand2]($player1, $player2);
        echo " equality on ".$hand1." wins ".$res;
        fprintf($fp, "%s\n", $res);
    }
    echo PHP_EOL;
}

fclose($fp);