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
    public function testCreateObjectWithArgument()
    {
        $game = new Game21();
        $this->assertInstanceOf("\App\Card\Game21", $game);
        $this->assertEquals($game->getDealer()->getName(), 'Banken');
        $this->assertEquals($game->getPlayers()[0]->getName(), 'Spelare 1');
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
     * Construct object and test to play the game with 1 player. Both player and
     * bank has 21 => bank is the winner.
     */
    public function testPlayEqualBankWins()
    {
        $game = new Game21();
        $result = $game->play();
        $this->assertEquals($game->getDealer()->getName(), 'Banken');
        $this->assertEquals($game->getPlayers()[0]->getName(), 'Spelare 1');
        $game->getDealer()->setContent();
        $game->getDealer()->setScoreLow(21);
        $game->getPlayers()[0]->setContent();
        $game->getPlayers()[0]->setScoreLow(21);
        $result = $game->play();
        $this->assertEquals($result, 'Vinnaren är: <br>Banken');
    }

    /**
     * Construct object and test to play the game with 1 player. Both player has
     * 20 and bank has 21 => bank is the winner.
     */
    public function testPlayBankWins()
    {
        $game = new Game21();
        $result = $game->play();
        $this->assertEquals($game->getDealer()->getName(), 'Banken');
        $this->assertEquals($game->getPlayers()[0]->getName(), 'Spelare 1');
        $game->getDealer()->setContent();
        $game->getDealer()->setScoreLow(21);
        $game->getPlayers()[0]->setContent();
        $game->getPlayers()[0]->setScoreLow(20);
        $result = $game->play();
        $this->assertEquals($result, 'Vinnaren är: <br>Banken');
    }

    /**
     * Construct object and test to play the game with 1 player. Both player has
     * 20 and bank has 18 => player is the winner.
     */
    public function testPlayPlayerWins()
    {
        $game = new Game21();
        $result = $game->play();
        $this->assertEquals($game->getDealer()->getName(), 'Banken');
        $this->assertEquals($game->getPlayers()[0]->getName(), 'Spelare 1');
        $game->getDealer()->setContent();
        $game->getDealer()->setScoreLow(18);
        $game->getPlayers()[0]->setContent();
        $game->getPlayers()[0]->setScoreLow(20);
        $result = $game->play();
        $this->assertEquals($result, 'Vinnaren är: <br>Spelare 1');
    }

    /**
     * Construct object and test to play the game with 1 player. Both player has
     * 20 and bank has more than 21 => player is the winner.
     */
    public function testPlayBankThickPlayerWins()
    {
        $game = new Game21();
        $result = $game->play();
        $this->assertEquals($game->getDealer()->getName(), 'Banken');
        $this->assertEquals($game->getPlayers()[0]->getName(), 'Spelare 1');
        $game->getDealer()->setContent();
        $game->getDealer()->setScoreLow(22);
        $game->getPlayers()[0]->setContent();
        $game->getPlayers()[0]->setScoreLow(20);
        $result = $game->play();
        $this->assertEquals($result, 'Vinnaren är: <br>Spelare 1');
    }

    /**
     * Construct object and test to play the game with 1 player. Both player has
     * 22 and bank has  20 => bank is the winner.
     */
    public function testPlayPlayerThickBankWins()
    {
        $game = new Game21();
        $result = $game->play();
        $this->assertEquals($game->getDealer()->getName(), 'Banken');
        $this->assertEquals($game->getPlayers()[0]->getName(), 'Spelare 1');
        $game->getDealer()->setContent();
        $game->getDealer()->setScoreLow(20);
        $game->getPlayers()[0]->setContent();
        $game->getPlayers()[0]->setScoreLow(22);
        $result = $game->play();
        $this->assertEquals($result, 'Vinnaren är: <br>Banken');
    }
}
