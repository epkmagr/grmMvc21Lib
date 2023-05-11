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
        $dealer = array();
        $player = array();
        $defaultData = array();

        $dealer["name"] = "Banken";
        $dealer["cards"] = [];
        $dealer["sum low/high"] = "0/0";
        $dealer["result"] = "";
        $player["name"] = "Spelare 1";
        $player["cards"] = [];
        $player["sum low/high"] = "0/0";
        $player["result"] = "Nytt kort?";
        $defaultData["no of players"] = 1;
        $defaultData["no of cards to draw"] = 1;
        $defaultData["Players info"][0] = $dealer;
        $defaultData["Players info"][1] = $player;
        $defaultData["remaining cards"] = 52;
        $defaultData["the winner is"] = '';
        $this->assertEquals($defaultData, $game->getJsonData());
    }
}
