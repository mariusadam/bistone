<?php

require 'vendor/autoload.php';

use Contest\Game\GameRules;
use Contest\Game\HandCalculator;
use Contest\Game\PokerGame;
use Contest\IO\FileReader;
use Contest\IO\FileWriter;

$reader = new FileReader('files/1.txt');
$writer = new FileWriter('files/out.txt');
$rules  = new GameRules(new HandCalculator());

$game = new PokerGame($reader, $writer, $rules);
$game->playRounds();

$writer->close();