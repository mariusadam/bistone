<?php

namespace Contest\Game;

use Contest\Model\Player;

class GameRules {
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
    const STRAIGHT_FLUSH = 7;

    /**
     * @var HandCalculator;
     */
    private $handCalculator;

    /**
     * @var array
     */
    private $rules;

    /**
     * Rules constructor.
     * @param HandCalculator $calculator
     */
    public function __construct(HandCalculator $calculator)
    {
        $this->handCalculator = $calculator;
        $this->configureRules();
    }

    /**
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @param Player $player1
     * @param Player $player2
     * @return Player | null
     */
    public function getWinner(Player $player1, Player $player2)
    {
        $hand1 = $this->handCalculator->getHandType($player1);
        $hand2 = $this->handCalculator->getHandType($player2);
        if ($hand1 > $hand2) {
            return $player1;
        } elseif ($hand2 > $hand1) {
            return $player2;
        } else {
            return $this->getRules()[$hand1]($player1, $player2);
        }

    }

    private function configureRules()
    {
        $this->rules = [
            self::NONE => function (Player $p1, Player $p2) {
                $s1 = $this->handCalculator->getArraySum($p1->getCodes());
                $s2 = $this->handCalculator->getArraySum($p2->getCodes());

                if ($s1 == $s2) {
                    return null;
                } elseif ($s1 > $s2) {
                    return $p1;
                } else {
                    return $p2;
                }
            },
            self::PAIR => function (Player $p1, Player $p2) {
                $c1 = $this->handCalculator->hasTwoOfAKind($p1);
                $c2 = $this->handCalculator->hasTwoOfAKind($p2);

                if ($c1 == $c2) {
                    return null;
                } elseif ($c1 > $c2) {
                    return $p1;
                } else {
                    return $p2;
                }
            },

            self::THREE_OF_A_KIND => function (Player $p1, Player $p2) {
                $c1 = $this->handCalculator->hasThreeOfAKind($p1);
                $c2 = $this->handCalculator->hasThreeOfAKind($p2);

                if ($c1 == $c2) {
                    return null;
                } elseif ($c1 > $c2) {
                    return $p1;
                } else {
                    return $p2;
                }
            },

            self::STRAIGHT => function (Player $p1, Player $p2) {
                $c1 = max($p1->getCodes());
                $c2 = max($p2->getCodes());
                if ($c1 == $c2) {
                    return null;
                } elseif ($c1 > $c2) {
                    return $p1;
                } else {
                    return $p2;
                }
            },

            self::FLUSH => function (Player $p1, Player $p2) {
                $c1 = max($p1->getCodes());
                $c2 = max($p2->getCodes());
                if ($c1 == $c2) {
                    return null;
                } elseif ($c1 > $c2) {
                    return $p1;
                } else {
                    return $p2;
                }
            },

            self::FULL => function (Player $p1, Player $p2) {
                $c1 = $this->handCalculator->getArraySum($p1->getCodes());
                $c2 = $this->handCalculator->getArraySum($p2->getCodes());

                if ($c1 == $c2) {
                    return null;
                } elseif ($c1 > $c2) {
                    return $p1;
                } else {
                    return $p2;
                }
            },

            self::STRAIGHT_FLUSH => function (Player $p1, Player $p2) {
                $c1 = max($p1->getCodes());
                $c2 = max($p2->getCodes());
                if ($c1 == $c2) {
                    return null;
                } elseif ($c1 > $c2) {
                    return $p1;
                } else {
                    return $p2;
                }
            },
        ];
    }
}