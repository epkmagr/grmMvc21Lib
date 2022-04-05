<?php

namespace App\Card;
/**
 * Class CardHand, a class that represents a hand of cards
 * using a namespace
 *
 * @author Marie Grahn, grmstud@student.bth.se
 */
class CardHand
{
    /**
     * @var array  $hand  The hand of the cards.
     */
    private $hand;

    /**
    * Constructor to create an object of Dice.
    *
    */
    public function __construct(array $hand = [])
    {
        $this->hand = $hand;
    }

    /**
    * Destroy an object of Dice.
    */
    /**
    * Destroy an object of Dice.
    */
    public function __destruct()
    {
        // echo __METHOD__;
    }

    /**
    * Get the hand of the cards.
    *
    * @return array
    */
    public function getCards()
    {
        return $this->hand;
    }

    /**
    * Get the sum of the cards. With ace counted as 14.
    *
    * @return int
    */
    public function getSumOfHandAceHigh()
    {
        $sum = 0;

        foreach ($this->hand as $card) {
            if ($card->getValue() === "A") {
                $sum += 14;
            } elseif ($card->getValue() === "K") {
                $sum += 13;
            } elseif ($card->getValue() === "Q") {
                $sum += 12;
            } elseif ($card->getValue() === "J") {
                $sum += 11;
            } else {
                $sum += intval($card->getValue());
            }
        }
        return $sum;
    }

    /**
    * Get the sum of the cards. With ace counted as 1.
    *
    * @return int
    */
    public function getSumOfHandAceLow()
    {
        $sum = 0;

        foreach ($this->hand as $card) {
            if ($card->getValue() === "A") {
                $sum += 1;
            } elseif ($card->getValue() === "K") {
                $sum += 13;
            } elseif ($card->getValue() === "Q") {
                $sum += 12;
            } elseif ($card->getValue() === "J") {
                $sum += 11;
            } else {
                $sum += intval($card->getValue());
            }
        }
        return $sum;
    }

    /**
    * Draw a new card and add it to the hand of the cards.
    *
    * @return void
    */
    public function addNewCard(Card $card)
    {
        array_push($this->hand, $card);
    }
}
