<?php

namespace App\Card;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Test cases for class Dice.
 */
class Deck2Test extends KernelTestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
     * Use no argument. Check that the number of cards is 52.
     */
    public function testCreateObjectWithArgument()
    {
        $deck = new Deck2();
        $this->assertInstanceOf("\App\Card\Deck2", $deck);
        $this->assertEquals(count($deck->getDeck()), 54);
    }

    /**
     * Construct object. Use no argument. Check some of the cards with getCard.
     * 0 is ace of clubs
     * 52 is joker
     * 53 is joker.
     */
    public function testGetDeck()
    {
        $deck = new Deck2();
        $cards = $deck->getDeck();
        $this->assertEquals('♣', $cards[0]->getSuit());
        $this->assertEquals('A', $cards[0]->getValue());
        $this->assertEquals('J', $cards[52]->getSuit());
        $this->assertEquals('J', $cards[52]->getValue());
        $this->assertEquals('J', $cards[53]->getSuit());
        $this->assertEquals('J', $cards[53]->getValue());
    }

    /**
     * Construct object. Use no argument. Shuffle.
     * Check some of the cards with getCard.
     * 0 is NOT ace of clubs
     * 51 is NOT king of spades.
     */
    public function testShuffle()
    {
        srand(12345);  // To seed random number for shuffle
        $deck = new Deck();
        $deck->shuffle();
        $card = $deck->getCard(0);
        $str = $card->getSuit().$card->getValue();
        $this->assertNotEquals($str, '♣A');
        $card = $deck->getCard(51);
        $str = $card->getSuit().$card->getValue();
        $this->assertNotEquals($str, '♠K');
    }

    /**
     * Construct object. Use no argument. Draw the top card and check that
     * the number of cards left is 51 and the next top card is 2 of spades.
     */
    public function testGetTopCard()
    {
        $deck = new Deck();
        $card = $deck->getTopCard();
        $this->assertEquals($card->getSuit(), '♣');
        $this->assertEquals($card->getValue(), 'A');
        $this->assertEquals(count($deck->getDeck()), 51);
        $card = $deck->getTopCard();
        $this->assertEquals($card->getSuit(), '♣');
        $this->assertEquals($card->getValue(), '2');
        $this->assertEquals(count($deck->getDeck()), 50);
    }

    /**
     * Construct Deck object. Use no argument. Shuffle the deck and sort it
     * and then check that the 1st and 11th card is clubs and that card 15
     * is diamonds, card 27 is spades and card 50 is heart.
     * Also testing function that returns the number of cards in the deck.
     */
    public function testSortDeck()
    {
        $deck = new Deck();
        $deck->shuffle();
        $sortedDeck = $deck->sortDeck();
        $this->assertEquals($deck->getNoOfCards(), 52);
        $cardImgFile = $sortedDeck[0][0];
        $this->assertEquals('C', $cardImgFile);
        $cardImgFile = $sortedDeck[11][0];
        $this->assertEquals('C', $cardImgFile);
        $cardImgFile = $sortedDeck[15][0];
        $this->assertEquals('D', $cardImgFile);
        $cardImgFile = $sortedDeck[27][0];
        $this->assertEquals('S', $cardImgFile);
        $cardImgFile = $sortedDeck[50][0];
        $this->assertEquals('H', $cardImgFile);
    }
}
