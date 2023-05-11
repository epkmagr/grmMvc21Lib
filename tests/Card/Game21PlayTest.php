<?php

namespace App\Card;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Test cases for class Dice.
 */
class Game21PlayTest extends KernelTestCase
{
    /**
     * Construct object and test to play the game with 1 player. Both player and
     * bank has 21 => bank is the winner.
     */
    public function testPlayEqualBankWins()
    {
        $game = new Game21();
        $game->play();
        $this->assertEquals($game->getDealer()->getName(), 'Banken');
        $this->assertEquals($game->getPlayers()[0]->getName(), 'Spelare 1');
        $game->getDealer()->setContent();
        $game->getDealer()->setScoreLow(21);
        $game->getPlayers()[0]->setContent();
        $game->getPlayers()[0]->setScoreLow(21);
        $result = $game->play();
        $this->assertEquals($result, 'Vinnaren är: <br>Banken');
        $this->assertTrue($game->isItGameover());
    }

    /**
     * Construct object and test to play the game with 1 player. Both player has
     * 20 and bank has 21 => bank is the winner.
     */
    public function testPlayBankWins()
    {
        $game = new Game21();
        $game->play();
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
     * Construct object and test to play the game with 1 player. Player has
     * 20 and bank has 18 => player is the winner.
     */
    public function testPlay1PlayerWins()
    {
        $game = new Game21();
        $game->play();
        $this->assertEquals($game->getDealer()->getName(), 'Banken');
        $this->assertEquals($game->getPlayers()[0]->getName(), 'Spelare 1');
        $game->getDealer()->setContent();
        $game->getPlayers()[0]->setContent();
        $game->play();
        $game->getDealer()->setScoreLow(18);
        $game->getPlayers()[0]->setScoreLow(20);
        $result = $game->result();
        $this->assertEquals($game->getWinner(), 'Spelare 1');
        $this->assertEquals($result, 'Vinnaren är: <br>Spelare 1');
    }

    /**
     * Construct object and test to play the game with 2 players. Player 1 has
     * 20, Player2 has 19 and bank has 18 => player is the winner.
     */
    public function testPlay2Players1stWins()
    {
        $game = new Game21();
        $game->initGame(2, 1);
        $game->play();
        $this->assertEquals($game->getDealer()->getName(), 'Banken');
        $this->assertEquals($game->getPlayers()[0]->getName(), 'Spelare 1');
        $this->assertEquals($game->getPlayers()[1]->getName(), 'Spelare 2');
        $game->getDealer()->setContent();
        $game->getDealer()->setBestScore(18);
        $game->getPlayers()[0]->setContent();
        $game->getPlayers()[0]->setBestScore(20);
        $game->getPlayers()[1]->setContent();
        $game->getPlayers()[1]->setBestScore(19);
        $this->assertEquals($game->result(), 'Vinnaren är: <br>Spelare 1');
        $this->assertEquals($game->getWinner(), 'Spelare 1');
    }

    /**
     * Construct object and test to play the game with 2 player. Player 1 has
     * 19, Player 2 has 20 and bank has 18 => player is the winner.
     */
    public function testPlay2Player2ndWins()
    {
        $game = new Game21();
        $game->initGame(2, 1);
        $game->play();
        $this->assertEquals($game->getDealer()->getName(), 'Banken');
        $this->assertEquals($game->getPlayers()[0]->getName(), 'Spelare 1');
        $this->assertEquals($game->getPlayers()[1]->getName(), 'Spelare 2');
        $game->getDealer()->setContent();
        $game->getDealer()->setBestScore(18);
        $game->getPlayers()[0]->setContent();
        $game->getPlayers()[0]->setBestScore(19);
        $game->getPlayers()[1]->setContent();
        $game->getPlayers()[1]->setBestScore(20);
        $result = $game->result();
        $this->assertEquals($game->getWinner(), 'Spelare 2');
        $this->assertEquals($result, 'Vinnaren är: <br>Spelare 2');
    }

    /**
     * Construct object and test to play the game with 2 player. Player 1 has
     * 20, Player 2 has 20 and bank has 18 => player is the winner.
     */
    public function testPlay2BothPlayersWins()
    {
        $game = new Game21();
        $game->initGame(2, 1);
        //$game->play();
        $card1 = new Card('♥', '10');
        $card2 = new Card('♣', '10');
        $this->assertEquals($game->getDealer()->getName(), 'Banken');
        $this->assertEquals($game->getPlayers()[0]->getName(), 'Spelare 1');
        $this->assertEquals($game->getPlayers()[1]->getName(), 'Spelare 2');
        $game->getDealer()->setContent();
        $game->getDealer()->setBestScore(18);
        $game->getPlayers()[0]->setContent();
        $game->getPlayers()[0]->increaseHand($card1);
        $game->getPlayers()[0]->increaseHand($card2);
        $game->getPlayers()[0]->setBestScore(20);
        $game->getPlayers()[1]->increaseHand($card1);
        $game->getPlayers()[1]->increaseHand($card2);
        $game->getPlayers()[1]->setContent();
        $game->getPlayers()[1]->setBestScore(20);
        $result = $game->result();
        $this->assertEquals('Spelare 1 & Spelare 2', $game->getWinner());
        $this->assertEquals('Vinnaren är: <br>Spelare 1 & Spelare 2', $result);
    }

    /**
     * Construct object and test to play the game with 1 player. Both player has
     * 20 and bank has more than 21 => player is the winner.
     */
    public function testPlayBankThickPlayerWins()
    {
        $game = new Game21();
        $game->play();
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
        $game->play();
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
