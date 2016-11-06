<?php

namespace Contest\Model;

class Player {
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $cards;

    /**
     * @var array
     */
    private $codes;

    /**
     * @var array
     */
    private $colours;

    /**
     * Player constructor.
     * @param $name
     * @param array $cards
     */
    public function __construct($name, array $cards)
    {
        $this->name  = $name;
        $this->cards = $cards;
    }

    /**
     * @return array
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * @param array $cards
     */
    public function setCards($cards)
    {
        $this->cards = $cards;
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

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

}