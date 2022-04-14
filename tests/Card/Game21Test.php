<?php

namespace App\Card;
use App\Card\Game21;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Test cases for class Dice.
 */
class Game21Test extends KernelTestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
     * Use no argument.
     */
    public function testCreateObjectWithArgument()
    {
        $game = new Game21();
        $this->assertInstanceOf("\App\Card\Game21", $game);
        $this->assertEquals($game->getDealer()->getName(), "Banken");
        $this->assertEquals($game->getPlayers()[0]->getName(), "Spelare 1");
    }

    /**
     * Construct object and test to init the game with 2 players.
     */
    public function testInitGame()
    {
        $game = new Game21();
        $game->initGame(2);
        $this->assertEquals($game->getDealer()->getName(), "Banken");
        $this->assertEquals($game->getPlayers()[0]->getName(), "Spelare 1");
        $this->assertEquals($game->getPlayers()[1]->getName(), "Spelare 2");
    }

    /**
     * Construct object and test to play the game with 1 player. Player wins.
     */
    public function testPlay()
    {
        $game = new Game21();
        $result = $game->play();
        $this->assertEquals($game->getDealer()->getName(), "Banken");
        $this->assertEquals($game->getPlayers()[0]->getName(), "Spelare 1");
        $result = $game->play();
    }
}
