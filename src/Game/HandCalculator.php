<?php

namespace Contest\Game;

use Contest\Model\Player;

class HandCalculator
{
    /**
     * @param Player $player
     * @return int
     */
    public function getHandType(Player $player)
    {
        $decoded = [];
        foreach ($player->getCards() as $card) {
            $decoded[] = [
                'code' => Mapper::getCardsValues()[$this->getCode($card)],
                'colour' => $this->getColour($card),
            ];
        }

        $codes = array_column($decoded, 'code');
        $colors = array_column($decoded, 'colour');
        $player->setCodes($codes);
        $player->setColours($colors);

        if ($this->isConsecutive($codes) && $this->isHomogeneous($colors)) {
            return GameRules::STRAIGHT_FLUSH;
        }

        if ($this->hasFourOfAKind($player) !== false) {
            return GameRules::FOUR;
        }

        if ($this->has3And2($player)) {
            return GameRules::FULL;
        }

        if ($this->isHomogeneous($colors)) {
            return GameRules::FLUSH;
        }

        if ($this->isConsecutive($codes)) {
            return GameRules::STRAIGHT;
        }

        if ($this->hasThreeOfAKind($player)) {
            return GameRules::THREE_OF_A_KIND;
        }

        if ($this->hasTwoOfAKind($player)) {
            return GameRules::PAIR;

        }

        return GameRules::NONE;
    }

    /**
     * @param $arr
     * @return bool
     */
    private function isHomogeneous(array $arr) {
        $firstValue = current($arr);
        foreach ($arr as $val) {
            if ($firstValue !== $val) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param array $array
     * @return bool
     */
    private function isConsecutive(array $array) {
        $set = array_unique($array);

        if (count($set) != count($array)) {
            return false;
        }

        return ((int)max($array)-(int)min($array) == (count($array)-1));
    }

    /**
     * @param $string
     * @return string
     */
    private function getColour($string) {
        return substr($string, -1);
    }

    /**
     * @param string $string
     * @return string
     */
    public function getCode($string) {
        $c = substr($string, 0, strlen($string) -1);

        return (string) $c;
    }

    /**
     * @param array $array
     * @param mixed $elem
     * @return int
     */
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

    /**
     * @param Player $player
     * @param $n
     * @return bool|mixed
     */
    private function hasNOfAKind(Player $player, $n) {
        foreach ($player->getCodes() as $value) {
            if ($this->getFrequency($player->getCodes(), $value) == $n) {
                return $value;
            }
        }

        return false;
    }

    /**
     * @param Player $player
     * @return bool|mixed
     */
    public function hasFourOfAKind(Player $player) {
        return $this->hasNOfAKind($player, 4);
    }

    /**
     * @param Player $player
     * @return bool|mixed
     */
    public function hasThreeOfAKind(Player $player) {
        return $this->hasNOfAKind($player, 3);
    }

    /**
     * @param Player $player
     * @return bool|int|mixed
     */
    public function hasTwoOfAKind(Player $player) {
        $value1 = -1;
        $codes = $player->getCodes();
        foreach ($codes as $value) {
            if ($this->getFrequency($codes, $value) == 2) {
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

    /**
     * @param array|Player $player
     * @return bool
     */
    public function has3And2(Player $player) {
        $codes = $player->getCodes();

        $set = array_values(array_unique($codes));
        if (count($set) != 2) {
            return false;
        }

        $f1 = $this->getFrequency($codes, $set[0]);
        $f2 = $this->getFrequency($codes, $set[1]);

        if ($f1 == 2 && $f2 == 3) {
            return true;
        }

        if ($f1 == 3 && $f2 == 2) {
            return true;
        }

        return false;
    }

    /**
     * @param array $array
     * @return int|mixed
     */
    public function getArraySum(array $array) {
        $sum = 0;
        foreach ($array as $value) {
            $sum += $value;
        }

        return $sum;
    }
}