<?php

namespace App\Card;

/**
 * A player with name, score and a hand of cards.
 *
 * @author Marie Grahn, mbfs17@student.bth.se
 */
class Player
{
    /**
     * @var string   the name of the player
     * @var CardHand the hand with cards
     * @var int      the score of the player
     */
    private $name;
    private $hand;
    private $score;

    /**
     * Constructor to initiate the dicehand with a number of dices.
     *
     * @param string $name the name of the player, default = ""
     */
    public function __construct(string $name = '')
    {
        $this->name = $name;
        $this->hand = new CardHand();
        $this->score = 0;
    }

    /**
     * Get the name of the player.
     *
     * @return string as the name of the player
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the name of the player.
     *
     * @param string $name the name of the player
     *
     * @return void
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get the score of the player.
     *
     * @return int as the score of the player
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set the score of the player.
     *
     * @param int $score the score of the player
     *
     * @return void
     */
    public function setScore(int $score)
    {
        $this->score = $score;
    }

    /**
     * Get the hand of cards of the player.
     *
     * @return CardHand as the hand of cards of the player
     */
    public function gethand()
    {
        return $this->hand;
    }

    /**
     * Set the score to the sum of cards in the hand. Ace is counted as 14.
     *
     * @return int as the sum of the dices in the hand of the player
     */
    public function getSumOfHandAceHigh()
    {
        $this->setScore($this->hand->getSumOfHandAceHigh());
    }

    /**
     * Set the score to the sum of cards in the hand. Ace is counted as 1.
     *
     * @return int as the sum of the dices in the hand of the player
     */
    public function getSumOfHandAceLow()
    {
        $this->setScore($this->hand->getSumOfHandAceLow());
    }

    /**
     * Increases the hand of cards with the top card of the deck.
     *
     * @param Card $card the deck of cards
     *
     * @return void
     */
    public function increaseHand(Card $card)
    {
        $this->hand->addNewCard($card);
    }
}
