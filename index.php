<?php

$cards_values = ["1"=>1, "2"=>2, "3"=>3, "4"=>4, "5"=>5, "6"=>6,"7"=>7,"8"=>8, "9"=>9, "10"=>10,"J"=>11, "Q"=>12, "K"=>13, "A"=>14];

$file = file_get_contents('files/1.txt');

$lines = explode("\n", $file);

print_r($lines);

class Rules {
    const NONE = 0;
    const PAIR = 1;
    const THREE_OF_A_KIND = 2;
    const STRAIGHT = 3;
    const FLUSH = 4;
    const FULL = 5;
    const FOUR = 6;
    const STRAIGHT_FLUSH = 10;
}

class Player {
    private $cards;

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

    }


}


