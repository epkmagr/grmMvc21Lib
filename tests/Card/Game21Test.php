<?php

namespace App\Card;

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
    public function testCreateObject()
    {
        $game = new Game21();
        $this->assertInstanceOf("\App\Card\Game21", $game);
        $this->assertEquals('Banken', $game->getDealer()->getName());
        $this->assertEquals('Spelare 1', $game->getPlayers()[0]->getName());
        $this->assertEquals(1, $game->getNoOfPlayers());
        $this->assertEquals(1, $game->getNoOfCards());
        $this->assertEquals(52, $game->getDeck()->getNoOfCards());
    }

    /**
     * Construct object and test to init the game with 2 players.
     */
    public function testInitGame()
    {
        $game = new Game21();
        $game->initGame(2);
        $this->assertEquals($game->getDealer()->getName(), 'Banken');
        $this->assertEquals($game->getPlayers()[0]->getName(), 'Spelare 1');
        $this->assertEquals($game->getPlayers()[1]->getName(), 'Spelare 2');
    }

    /**
     * Construct object and get all json information.
     */
    public function testCreateGameAndGetJsonInfo()
    {
        $game = new Game21();
        $this->assertEquals("Banken", $game->getAllPlayersInfo(true)[0]["name"]);
        $this->assertEquals("", $game->getAllPlayersInfo(true)[0]["result"]);
        $this->assertEquals("Spelare 1", $game->getAllPlayersInfo(true)[1]["name"]);
        $this->assertEquals("Nytt kort?", $game->getAllPlayersInfo(true)[1]["result"]);
    }
}
