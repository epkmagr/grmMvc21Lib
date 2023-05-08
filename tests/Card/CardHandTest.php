<?php

namespace App\Card;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Test cases for class Dice.
 */
class CardHandTest extends KernelTestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
     * Use no argument.
     */
    public function testCreateObjectNoArgument()
    {
        $cardHand = new CardHand();
        $this->assertInstanceOf("\App\Card\CardHand", $cardHand);
        $this->assertEquals([], $cardHand->getCards());
    }

    /**
     * Construct object and verify that the object is of expected instance.
     * Use valid argument.
     */
    public function testCreateObjectWithArgument()
    {
        $cardHand = new Card('♥', '7');
        $this->assertEquals('♥', $cardHand->getSuit());
        $this->assertEquals('7', $cardHand->getValue());
    }

    /**
     * Construct object, add 2 cards and verify length of hand.
     */
    public function testAddNewCard()
    {
        $cardHand = new CardHand();
        $cardHand->addNewCard(new Card('♥', '7'));
        $cardHand->addNewCard(new Card('♣', '8'));
        $this->assertEquals(2, count($cardHand->getCards()));
    }

    /**
     * Construct object, add 2 cards and verify Json format.
     */
    public function testAddNewCardJson()
    {
        $cardHand = new CardHand();
        $cardHand->addNewCard(new Card('♥', '7'));
        $cardHand->addNewCard(new Card('♣', '8'));
        $this->assertEquals(2, count($cardHand->getCardsJson()));
        $this->assertEquals('♥7', $cardHand->getCardsJson()[0]);
        $this->assertEquals('♣8', $cardHand->getCardsJson()[1]);
    }

    /**
     * Construct object, add 2 cards and verify image format, i.e. filename.
     */
    public function testAddNewCardImg()
    {
        $cardHand = new CardHand();
        $cardHand->addNewCard(new Card('♥', '7'));
        $cardHand->addNewCard(new Card('♣', '8'));
        $this->assertEquals('H7.png', $cardHand->getCardsImg()[0]);
        $this->assertEquals('C8.png', $cardHand->getCardsImg()[1]);
    }

    /**
     * Construct object, add 2 cards with one ace and verify length of hand.
     */
    public function testGetSumOfHandAceLow()
    {
        $cardHand = new CardHand();
        $cardHand->addNewCard(new Card('♥', 'A'));
        $cardHand->addNewCard(new Card('♣', '7'));
        $this->assertEquals($cardHand->getSumOfHandAceLow(), 8);
    }

    /**
     * Construct object, add 2 cards with one ace and verify length of hand.
     */
    public function testGetSumOfHandAceHigh()
    {
        $cardHand = new CardHand();
        $cardHand->addNewCard(new Card('♥', 'A'));
        $cardHand->addNewCard(new Card('♣', '7'));
        $this->assertEquals($cardHand->getSumOfHandAceHigh(), 21);
    }
}
