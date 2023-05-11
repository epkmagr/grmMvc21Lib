<?php

namespace App\Card;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Test cases for class Dice.
 */
class DealerTest extends KernelTestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
     * Use valid argument. Test that the name is set, that no of cards in hand
     * is 0.
     */
    public function testCreateObjectWithArgument()
    {
        $bank = new Dealer('Banken');
        $this->assertInstanceOf("\App\Card\Dealer", $bank);
        $this->assertEquals($bank->getName(), 'Banken');
        $this->assertEquals($bank->getNoOfCards(), 0);
    }

    /**
     * Construct object and verify that the object is of expected instance.
     * Use valid argument. Test that the player is content when having sum >= 18.
     */
    public function testGetResultContent()
    {
        $player = new Dealer('Spelare 1');
        $card1 = new Card('♥', '7');
        $player->increaseHand($card1);
        $card2 = new Card('♥', 'A');
        $player->increaseHand($card2);
        $player->getSumOfHand();
        $this->assertEquals($player->getResult(), 'NÖJD');
    }

    /**
     * Construct object and verify that the object is of expected instance.
     * Use valid argument. Test that the player not is content when having sum < 18.
     */
    public function testGetResultNotContent()
    {
        $player = new Dealer('Spelare 1');
        $card1 = new Card('♥', '7');
        $player->increaseHand($card1);
        $card2 = new Card('♥', '1');
        $player->increaseHand($card2);
        $player->getSumOfHand();
        $this->assertEquals($player->getResult(), '');
    }

    /**
     * Construct object and verify that the object is of expected instance.
     * Use valid argument. Test that the player's result is 'FÖRLUST' when
     * having sum > 21.
     */
    public function testGetResultLoss()
    {
        $player = new Dealer('Spelare 1');
        $card1 = new Card('♥', '10');
        $player->increaseHand($card1);
        $card2 = new Card('♥', 'K');
        $player->increaseHand($card2);
        $player->getSumOfHand();
        $this->assertEquals($player->getResult(), 'FÖRLUST');
    }

    /**
     * Construct object and verify that the object is of expected instance.
     * Use valid argument. Test that the player's result is 'FÖRLUST' when
     * having sum > 21.
     */
    public function testGetResultScoreHighLargerThanScoreLow()
    {
        $player = new Dealer('Spelare 1');
        $card1 = new Card('♥', '1');
        $player->increaseHand($card1);
        $card2 = new Card('♥', 'A');
        $player->increaseHand($card2);
        $player->getSumOfHand();
        $this->assertEquals(2, $player->getScoreLow());
        $this->assertEquals(15, $player->getScoreHigh());
        $this->assertEquals('', $player->getResult());
    }
}
