<?php

namespace App\Card;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Test cases for class Dice.
 */
class ParticipantTest extends KernelTestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
     * Use valid argument. Test that the name is set, that no of cards in hand
     * is 0.
     */
    public function testCreateObjectWithArgument()
    {
        $part = new Participant('Test');
        $this->assertInstanceOf("\App\Card\Participant", $part);
        $this->assertEquals($part->getName(), 'Test');
        $this->assertEquals($part->getNoOfCards(), 0);
    }

    /**
     * Construct object and verify that the object is of expected instance.
     * Use valid argument. Test that the number of cards is 2 when
     * increaseHand is called twice.
     */
    public function testIncreaseHand()
    {
        $part = new Participant('Test');
        $card1 = new Card('&hearts;', '7');
        $part->increaseHand($card1);
        $card2 = new Card('&hearts;', 'A');
        $part->increaseHand($card2);
        $this->assertEquals(count($part->getHand()->getCards()), 2);
    }

    /**
     * Construct object and verify that the object is of expected instance.
     * Use valid argument. Test getSumOfHand, setScoreLow and setScoreHigh.
     * Also tests getScoreLow and getScoreHigh.
     */
    public function testGetSumOfHand()
    {
        $part = new Participant('Test');
        $card1 = new Card('&hearts;', '7');
        $part->increaseHand($card1);
        $card2 = new Card('&hearts;', 'A');
        $part->increaseHand($card2);
        $part->getSumOfHand();
        $this->assertEquals($part->getScoreLow(), 8);
        $this->assertEquals($part->getScoreHigh(), 21);
    }
}
