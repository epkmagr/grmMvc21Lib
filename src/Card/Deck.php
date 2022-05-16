<?php

namespace App\Card;

/**
 * Class Deck, represents a ordinary deck of cards with 52 cards.
 *
 * @author Marie Grahn, grmstud@student.bth.se
 */
class Deck
{
    public const VALUES = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];
    public const SUITS = ['&clubs;', '&diams;', '&hearts;', '&spades;'];

    /**
     * @var array<Card> $cards the deck of the cards.
     */
    private $cards;

    /**
     * Constructor to create an object of Dice.
     */
    public function __construct()
    {
        // Generate deck
        $this->cards = [];

        foreach (self::SUITS as $suit) {
            foreach (self::VALUES as $value) {
                $card = new Card($suit, $value);
                array_push($this->cards, $card);
            }
        }
    }

    /**
     * Destroy an object of Dice.
     */
    public function __destruct()
    {
        // echo __METHOD__;
    }

    /**
     * Get the deck of the cards.
     *
     * @return array<Card>
     */
    public function getDeck()
    {
        return $this->cards;
    }

    // /**
    //  * Get the deck of the cards in Json.
    //  *
    //  * @return array
    //  */
    // public function getDeckJson()
    // {
    //     $deck = new Deck();
    //     foreach ($this->cards as $card) {
    //         $aCard = new Card();
    //         $aCard->suit = $card->suit;
    //         $aCard->value = $card->value;
    //         $deck->append($aCard);
    //     }
    //
    //     return $deck;
    // }

    /**
     * Get card number $number in the deck of the cards.
     *
     * @param int $number the card to get
     *
     * @return Card
     */
    public function getCard(int $number)
    {
        $card = $this->cards[$number];
        unset($this->cards[$number]);
        array_values($this->cards);

        return $card;
    }

    /**
     * Get card number $number in the deck of the cards.
     *
     * @return Card
     */
    public function getTopCard()
    {
        return array_shift($this->cards);
    }

    /**
     * Shuffle the deck of the cards.
     *
     * @return void
     */
    public function shuffle()
    {
        shuffle($this->cards);
    }
}
