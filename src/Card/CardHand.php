<?php

namespace App\Card;

/**
 * Class CardHand, a class that represents a hand of cards
 * using a namespace.
 *
 * @author Marie Grahn, grmstud@student.bth.se
 */
class CardHand
{
    /**
     * @var array<Card> $hand the hand of the cards
     */
    private $hand;

    /**
     * Constructor to create an object of Dice.
     *
     * @param array<Card> $hand the hand of the cards
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
     * @return array<Card>
     */
    public function getCards()
    {
        return $this->hand;
    }

        /**
     * Get the hand of the cards in json format.
     *
     * @return array<int, string>
     */
    public function getCardsJson()
    {
        $hand = array();

        foreach ($this->hand as $card) {
            array_push($hand, $card->getSuit() . $card->getValue());
        }

        return $hand;
    }

    /**
     * Get the hand of the cards with images.
     *
     * @return array<int, string>
     */
    public function getCardsImg()
    {
        $cardsImg = [];

        foreach ($this->hand as $card) {
            array_push($cardsImg, $card->getImgUrl());
        }
        return $cardsImg;
    }

    /**
     * Get the sum of the cards. With ace counted as 14.
     * @SuppressWarnings(PHPMD.ElseExpression)
     *
     * @return int
     */
    public function getSumOfHandAceHigh()
    {
        $sum = 0;

        foreach ($this->hand as $card) {
            if ('A' === $card->getValue()) {
                $sum += 14;
            } elseif ('K' === $card->getValue()) {
                $sum += 13;
            } elseif ('Q' === $card->getValue()) {
                $sum += 12;
            } elseif ('J' === $card->getValue()) {
                $sum += 11;
            } else {
                $sum += intval($card->getValue());
            }
        }

        return $sum;
    }

    /**
     * Get the sum of the cards. With ace counted as 1.
     * @SuppressWarnings(PHPMD.ElseExpression)
     *
     * @return int
     */
    public function getSumOfHandAceLow()
    {
        $sum = 0;

        foreach ($this->hand as $card) {
            if ('A' === $card->getValue()) {
                ++$sum;
            } elseif ('K' === $card->getValue()) {
                $sum += 13;
            } elseif ('Q' === $card->getValue()) {
                $sum += 12;
            } elseif ('J' === $card->getValue()) {
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
     * @param Card $card the card added to the hand
     *
     * @return void
     */
    public function addNewCard(Card $card)
    {
        array_push($this->hand, $card);
    }
}
