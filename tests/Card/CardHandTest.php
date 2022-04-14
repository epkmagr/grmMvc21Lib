<?php

namespace App\Card;
use App\Card\CardHand;
use App\Card\Card;

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
        $this->assertEquals($cardHand->getCards(), []);
    }

    /**
     * Construct object and verify that the object is of expected instance.
     * Use valid argument.
     */
    public function testCreateObjectWithArgument()
    {
        $cardHand = new Card("&hearts;", "7");
        $this->assertEquals($cardHand->getSuit(), "&hearts;");
        $this->assertEquals($cardHand->getValue(), "7");
    }

    /**
     * Construct object, add 2 cards and verify length of hand
     */
    public function testAddNewCard()
    {
        $cardHand = new CardHand();
        $cardHand->addNewCard(new Card("&hearts;", "7"));
        $cardHand->addNewCard(new Card("&clubs;", "8"));
        $this->assertEquals(count($cardHand->getCards()), 2);
    }

    /**
     * Construct object, add 2 cards with one ace and verify length of hand
     */
    public function testGetSumOfHandAceLow()
    {
        $cardHand = new CardHand();
        $cardHand->addNewCard(new Card("&hearts;", "A"));
        $cardHand->addNewCard(new Card("&clubs;", "7"));
        $this->assertEquals($cardHand->getSumOfHandAceLow(), 8);
    }

    /**
     * Construct object, add 2 cards with one ace and verify length of hand
     */
    public function testGetSumOfHandAceHigh()
    {
        $cardHand = new CardHand();
        $cardHand->addNewCard(new Card("&hearts;", "A"));
        $cardHand->addNewCard(new Card("&clubs;", "7"));
        $this->assertEquals($cardHand->getSumOfHandAceHigh(), 21);
    }
}
