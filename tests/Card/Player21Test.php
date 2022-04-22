<?php

namespace App\Card;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Test cases for class Dice.
 */
class Player21Test extends KernelTestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
     * Use valid argument. Test that the name is set, that no of cards in hand
     * is 0.
     */
    public function testCreateObjectWithArgument()
    {
        $player = new Player21('Spelare 1');
        $this->assertInstanceOf("\App\Card\Player21", $player);
        $this->assertEquals($player->getName(), 'Spelare 1');
        $this->assertEquals($player->getNoOfCards(), 0);
    }

    /**
     * Construct object and verify that the object is of expected instance.
     * Use valid argument. Test that the player is content when having sum >= 18.
     */
    public function testGetResultContent()
    {
        $player = new Player21('Spelare 1');
        $card1 = new Card('&hearts;', '7');
        $player->increaseHand($card1);
        $card2 = new Card('&hearts;', 'A');
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
        $player = new Player21('Spelare 1');
        $card1 = new Card('&hearts;', '7');
        $player->increaseHand($card1);
        $card2 = new Card('&hearts;', '1');
        $player->increaseHand($card2);
        $player->getSumOfHand();
        $this->assertEquals($player->getResult(), 'Nytt kort?');
    }

    /**
     * Construct object and verify that the object is of expected instance.
     * Use valid argument. Test that the player's result is 'FÖRLUST' when
     * having sum > 21.
     */
    public function testGetResultLoss()
    {
        $player = new Player21('Spelare 1');
        $card1 = new Card('&hearts;', '10');
        $player->increaseHand($card1);
        $card2 = new Card('&hearts;', 'K');
        $player->increaseHand($card2);
        $player->getSumOfHand();
        $this->assertEquals($player->getResult(), 'FÖRLUST');
    }
}
