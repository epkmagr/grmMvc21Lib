<?php

namespace App\Card;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Test cases for class Dice.
 */
class PlayerTest extends KernelTestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
     * Use valid argument. Test that the name is set, that no of cards in hand
     * is 0.
     */
    public function testCreateObjectWithArgument()
    {
        $player = new Player('Spelare 1');
        $this->assertInstanceOf("\App\Card\Player", $player);
        $this->assertEquals($player->getName(), 'Spelare 1');
        $this->assertEquals($player->getNoOfCards(), 0);
    }


    /**
     * Construct object without input and set input and verify it.
     */
    public function testGetResultNotContent()
    {
        $player = new Player();
        $player->setName('Spelare 1');
        $this->assertEquals('Spelare 1', $player->getName());
        $card1 = new Card('♥', '7');
        $player->increaseHand($card1);
        $card2 = new Card('♥', '1');
        $player->increaseHand($card2);
        $this->assertEquals(2, $player->getNoOfCards());
    }

    /**
     * Construct object without input and set input and verify it.
     */
    public function testGethand()
    {
        $player = new Player('Spelare 1');
        $card1 = new Card('♥', '7');
        $player->increaseHand($card1);
        $card2 = new Card('♣', '1');
        $player->increaseHand($card2);
        $cardHand = new CardHand();
        $cardHand->addNewCard(new Card('♥', '7'));
        $cardHand->addNewCard(new Card('♣', '1'));
        $this->assertEquals(2, $player->getNoOfCards());
        $this->assertEquals($cardHand, $player->gethand());
    }

    /**
     * Construct object and verify that the object is of expected instance.
     * Use valid argument.
     */
    public function testGetResultContent()
    {
        $player = new Player('Spelare 1');
        $card1 = new Card('♥', '7');
        $player->increaseHand($card1);
        $card2 = new Card('♥', 'Q');
        $player->increaseHand($card2);
        $player->getSumOfHandAceHigh();
        $player->getSumOfHandAceLow();
        $player->setContent();
        $this->assertEquals(19, $player->getScoreLow());
        $this->assertEquals(19, $player->getScoreHigh());
        $this->assertEquals($player->getPlayerResult(), 'Nytt kort?');
        $this->assertEquals(19, $player->getBestScore());
        $this->assertTrue($player->isContent());
    }

    /**
     * Construct Player object and verify score low.
     */
    public function testGetResultContentScoreLow()
    {
        $player = new Player('Spelare 1');
        $card1 = new Card('♥', '7');
        $player->increaseHand($card1);
        $card2 = new Card('♥', 'A');
        $player->increaseHand($card2);
        $card3 = new Card('♥', 'K');
        $player->increaseHand($card3);
        $player->getSumOfHandAceHigh();
        $player->getSumOfHandAceLow();
        $this->assertEquals(21, $player->getScoreLow());
        $this->assertEquals(34, $player->getScoreHigh());
        $this->assertEquals($player->getPlayerResult(), 'VINST');
        $this->assertEquals(21, $player->getBestScore());
    }

    /**
     * Construct Player object and verify score high
     */
    public function testGetResultContentScoreHigh()
    {
        $player = new Player('Spelare 1');
        $card1 = new Card('♥', '7');
        $player->increaseHand($card1);
        $card2 = new Card('♥', 'A');
        $player->increaseHand($card2);
        $player->getSumOfHandAceHigh();
        $player->getSumOfHandAceLow();
        $this->assertEquals(8, $player->getScoreLow());
        $this->assertEquals(21, $player->getScoreHigh());
        $this->assertEquals($player->getPlayerResult(), 'VINST');
        $this->assertEquals(21, $player->getBestScore());
    }

    /**
     * Construct Player object and verify score high
     */
    public function testGetResultContentScoreLoss()
    {
        $player = new Player('Spelare 1');
        $card1 = new Card('♥', '7');
        $player->increaseHand($card1);
        $card2 = new Card('♥', '2');
        $player->increaseHand($card2);
        $card3 = new Card('♥', 'K');
        $player->increaseHand($card3);
        $player->getSumOfHandAceHigh();
        $player->getSumOfHandAceLow();
        $this->assertEquals(22, $player->getScoreLow());
        $this->assertEquals(22, $player->getScoreHigh());
        $this->assertEquals($player->getPlayerResult(), 'FÖRLUST');
        $this->assertEquals(0, $player->getBestScore());
    }

    /**
     * Construct Bank object and verify score low.
     */
    public function testGetResultContentBankScoreLow()
    {
        $player = new Player('Banken');
        $card1 = new Card('♥', '7');
        $player->increaseHand($card1);
        $card2 = new Card('♥', 'A');
        $player->increaseHand($card2);
        $card3 = new Card('♥', 'K');
        $player->increaseHand($card3);
        $player->getSumOfHandAceHigh();
        $player->getSumOfHandAceLow();
        $this->assertEquals(21, $player->getScoreLow());
        $this->assertEquals(34, $player->getScoreHigh());
        $this->assertEquals($player->getBankResult(), 'NÖJD');
        $this->assertEquals(21, $player->getBestScore());
    }

    /**
     * Construct Bank object and verify score high
     */
    public function testGetResultContentBankScoreHigh()
    {
        $player = new Player('Banken');
        $card1 = new Card('♥', '7');
        $player->increaseHand($card1);
        $card2 = new Card('♥', 'A');
        $player->increaseHand($card2);
        $player->getSumOfHandAceHigh();
        $player->getSumOfHandAceLow();
        $this->assertEquals(8, $player->getScoreLow());
        $this->assertEquals(21, $player->getScoreHigh());
        $this->assertEquals($player->getBankResult(), 'NÖJD');
        $this->assertEquals(21, $player->getBestScore());
    }

    /**
     * Construct Bank object and verify score high
     */
    public function testGetResultContentBankScoreLoss()
    {
        $player = new Player('Banken');
        $card1 = new Card('♥', '7');
        $player->increaseHand($card1);
        $card2 = new Card('♥', '2');
        $player->increaseHand($card2);
        $this->assertEquals($player->getBankResult(), '');
        $card3 = new Card('♥', 'K');
        $player->increaseHand($card3);
        $player->getSumOfHandAceHigh();
        $player->getSumOfHandAceLow();
        $this->assertEquals(22, $player->getScoreLow());
        $this->assertEquals(22, $player->getScoreHigh());
        $this->assertEquals($player->getBankResult(), 'FÖRLUST');
        $this->assertEquals(0, $player->getBestScore());
    }
}
