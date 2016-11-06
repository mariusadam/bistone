<?php

namespace Contest\Game;

use Contest\IO\FileReader;
use Contest\IO\FileWriter;
use Contest\Model\Player;

class PokerGame
{
    /**
     * @var FileReader
     */
    private $reader;

    /**
     * @var FileWriter
     */
    private $writer;

    /**
     * @var GameRules
     */
    private $gameRules;

    /**
     * PokerGame constructor.
     * @param FileReader $reader
     * @param FileWriter $writer
     * @param GameRules $gameRules
     */
    public function __construct(FileReader $reader, FileWriter $writer, GameRules $gameRules)
    {
        $this->reader    = $reader;
        $this->writer    = $writer;
        $this->gameRules = $gameRules;
    }

    public function playRounds()
    {
        $player1 = new Player(GameRules::FIRST, []);
        $player2 = new Player(GameRules::SECOND, []);

        foreach ($this->reader->getLines() as $line) {

            $array = explode(' ', $line);

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

            $winner = $this->gameRules->getWinner($player1, $player2);
            $this->writer->writeString($winner === null ? GameRules::DRAW : $winner->getName());
            $this->writer->writeln();
        }

    }
}