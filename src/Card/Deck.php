<?php

namespace App\Card;

/**
 * Class Dice, a class that represents a dice with
 * using a namespace
 *
 * @author Marie Grahn, grmstud@student.bth.se
 */
class Deck
{
    const VALUES = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];
    const SUITS = ['&clubs;', '&diams;', '&hearts;', '&spades;'];
    /**
     * @var int  $noOfCards  The number of the cards in the deck. Default is 52.
     * @var array  $cards  The deck of the cards.
     */
    private $noOfCards;
    private $cards;

    /**
    * Constructor to create an object of Dice.
    *
    */
    public function __construct(int $noOfCards = 52)
    {
        //Generate deck
        $this->cards = [];
        $card;
        foreach (self::SUITS as $suit) {
            foreach (self::VALUES as $value) {
                $card = new Card($suit, $value);
                array_push($this->cards, $card);
            }
        }
        $this->noOfCards = $noOfCards;
        if ($noOfCards === 54) {
            $cards[] = "J";
            $cards[] = "J";
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
    * @return array
    */
    public function getDeck()
    {
        return $this->cards;
    }

    /**
    * Get card number $number in the deck of the cards.
    *
    * @var integer $number    The card to get.
    *
    * @return array
    */
    public function getCard(int $number)
    {
        $card = $this->cards[$number];
        unset($this->cards[$number]);
        $this->noOfCards -= 1;

        return $card;
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

$deck = new Deck();
//
// var_dump($deck->getDeck());
//
// foreach( $deck as $card ) {
//     echo "Kort 1: " . card.suit . " " . card.value;
// }
