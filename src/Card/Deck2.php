<?php

namespace App\Card;

/**
 * Class Deck, represents a ordinary deck of cards with 52 cards and 2 jacks.
 * A total of 54 cards.
 *
 * @author Marie Grahn, grmstud@student.bth.se
 */
class Deck2 extends Deck
{
    /**
     * @var array<Card> the deck of the cards
     */
    private $cards;

    /**
     * Constructor to create an object of Dice.
     */
    public function __construct()
    {
        // Generate deck
        $this->cards = [];

        parent::__construct();
        $this->cards = parent::getDeck();

        $card = new Card('J', 'J');
        array_push($this->cards, $card);
        $card = new Card('J', 'J');
        array_push($this->cards, $card);
    }

    /**
     * Destroy an object of Dice.
     */
    public function __destruct()
    {
        // echo __METHOD__;
    }

    /**
     * Get the deck of the cards with 2 jokers.
     *
     * @return array<Card>
     */
    public function getDeck()
    {
        return $this->cards;
    }
}
