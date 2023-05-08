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

    public const SUITS = ['♣', '♦', '♠', '♥'];
    //public const SUITS = ['&clubs;', '&diams;', '&hearts;', '&spades;'];

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
     * @return array<int, Card>
     */
    public function getDeck()
    {
        return $this->cards;
    }

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
     * @return Card|null
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
    public function shuffle(): void
    {
        shuffle($this->cards);
    }

    /**
     * Get number of remaining cards in the deck.
     *
     * @return int
     */
    public function getNoOfCards(): int
    {
        return count($this->cards);
    }

    /**
     * Sorts the remaining cards in the deck according to color.
     *
     * @return array
     */
    public function sortDeck(): array
    {
        $cardsImg = [];
        $clubsImg = [];
        $diamsImg = [];
        $spadesImg = [];
        $heartsImg = [];

        foreach ($this->cards as $card) {
            if ($card->getSuit() === '♣') {
                array_push($clubsImg, $card->getImgUrl());
            }
            if ($card->getSuit() === '♦') {
                array_push($diamsImg, $card->getImgUrl());
            }
            if ($card->getSuit() === '♠') {
                array_push($spadesImg, $card->getImgUrl());
            }
            if ($card->getSuit() === '♥') {
                array_push($heartsImg, $card->getImgUrl());
            }
        }
        $cardsImg = array_merge($clubsImg, $diamsImg, $spadesImg, $heartsImg);

        return $cardsImg;
    }
}
