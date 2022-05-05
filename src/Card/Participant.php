<?php

namespace App\Card;

/**
 * Class Participant, base class to Dealer and Player.
 *
 * @author Marie Grahn, mbfs17@student.bth.se
 */
class Participant
{
    /**
     * @var string $name the name of the player
     * @var CardHand $hand the hand with cards
     * @var int $scoreLow the scoreLow of the player with ace as 1
     * @var int $scoreHigh the scoreHigh of the player with ace as 14
     * @var int $bestScore the bestScore of the player, scoreLow or scoreHigh
     * @var bool $content true if the player is content, false otherwise
     */
    private $name;
    private $hand;
    protected $scoreLow;
    protected $scoreHigh;
    protected $bestScore;
    protected $content;

    /**
     * Constructor to initiate the dicehand with a number of dices.
     *
     * @param string $name the name of the player, default = ""
     */
    public function __construct(string $name = '')
    {
        $this->name = $name;
        $this->hand = new CardHand();
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
     * Get the hand of cards of the player.
     *
     * @return CardHand as the hand of cards of the player
     */
    public function gethand()
    {
        return $this->hand;
    }

    /**
     * Get the number of cards in the hand of the player.
     *
     * @return int as the number of cards in the hand
     */
    public function getNoOfCards()
    {
        return (empty($this->hand->getCards())) ? 0 : count($this->hand->getCards());
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

    /**
     * Get the scoreLow of the player. Ace counted as 1.
     *
     * @return int $scoreLow as the scoreLow of the player
     */
    public function getScoreLow()
    {
        return $this->scoreLow;
    }

    /**
     * Set the scoreLow of the player. Ace counted as 1.
     *
     * @param int $scoreLow the scoreLow of the player
     *
     * @return void
     */
    public function setScoreLow(int $score)
    {
        $this->scoreLow = $score;
    }

    /**
     * Get the scoreHigh of the player.
     *
     * @return int $scoreHigh as the scoreHigh of the player
     */
    public function getScoreHigh()
    {
        return $this->scoreHigh;
    }

    /**
     * Set the scoreHigh of the player. Ace counted as 14.
     *
     * @param int $scoreHigh the scoreHigh of the player
     *
     * @return void
     */
    public function setScoreHigh(int $score)
    {
        $this->scoreHigh = $score;
    }

    /**
     * Get the best score of the player.
     *
     * @return int $bestScore as the bestScore of the player
     */
    public function getBestScore()
    {
        return $this->bestScore;
    }

    /**
     * Set the score to the sum of cards in the hand. Ace is counted as 1.
     */
    public function getSumOfHand()
    {
        $this->setScoreLow($this->hand->getSumOfHandAceLow());
        $this->setScoreHigh($this->hand->getSumOfHandAceHigh());
    }

    /**
     * Returns true if the player is content.
     *
     * @return bool as true if the player is content, false otherwise
     */
    public function isContent()
    {
        return $this->content;
    }

    /**
     * Set the player content.
     *
     * @return void
     */
    public function setContent()
    {
        $this->content = true;
    }
}
