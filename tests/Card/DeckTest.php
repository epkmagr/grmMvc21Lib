<?php

namespace App\Card;
use App\Card\Deck;
use App\Card\Card;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Test cases for class Dice.
 */
class DeckTest extends KernelTestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
     * Use no argument. Check that the number of cards is 52.
     */
    public function testCreateObjectWithArgument()
    {
        $deck = new Deck();
        $this->assertInstanceOf("\App\Card\Deck", $deck);
        $this->assertEquals(count($deck->getDeck()), 52);
    }

    /**
     * Construct object. Use no argument. Check some of the cards with getCard.
     * 0 is ace of clubs
     * 13 is ace of diams
     * 51 is king of spades
     */
    public function testGetCard()
    {
        $deck = new Deck();
        $card = $deck->getCard(0);
        $this->assertEquals($card->getSuit(), '&clubs;');
        $this->assertEquals($card->getValue(), 'A');
        $card = $deck->getCard(13);
        $this->assertEquals($card->getSuit(), '&diams;');
        $this->assertEquals($card->getValue(), 'A');
        $card = $deck->getCard(51);
        $this->assertEquals($card->getSuit(), '&spades;');
        $this->assertEquals($card->getValue(), 'K');
    }

    /**
     * Construct object. Use no argument. Shuffle.
     * Check some of the cards with getCard.
     * 0 is NOT ace of clubs
     * 51 is NOT king of spades
     */
    public function testShuffle()
    {
        $deck = new Deck();
        $deck->shuffle();
        $card = $deck->getCard(0);
        $str = $card->getSuit() . $card->getValue();
        $this->assertNotEquals($str, '&clubs;A');
        $card = $deck->getCard(51);
        $str = $card->getSuit() . $card->getValue();
        $this->assertNotEquals($str, '&spades;K');
    }

    /**
     * Construct object. Use no argument. Draw the top card and check that
     * the number of cards left is 51 and the next top card is 2 of spades.
     */
    public function testGetTopCard()
    {
        $deck = new Deck();
        $card = $deck->getTopCard();
        $this->assertEquals($card->getSuit(), '&clubs;');
        $this->assertEquals($card->getValue(), 'A');
        $this->assertEquals(count($deck->getDeck()), 51);
        $card = $deck->getTopCard();
        $this->assertEquals($card->getSuit(), '&clubs;');
        $this->assertEquals($card->getValue(), '2');
        $this->assertEquals(count($deck->getDeck()), 50);
    }
}
