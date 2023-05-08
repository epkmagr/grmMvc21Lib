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
     * @var int $scoreLow the scoreLow of the player with ace as 1
     * @var int $scoreHigh the scoreHigh of the player with ace as 14
     * @var int $bestScore the bestScore of the player, scoreLow or scoreHigh
     * @var bool $content true if the player is content, false otherwise
     */
    private $name;
    /**
     * @var CardHand $hand the hand with cards
     */
    private $hand;
    protected int $scoreLow;
    protected int $scoreHigh;
    protected int $bestScore;
    protected bool $content;

    /**
     * Constructor to initiate the dicehand with a number of dices.
     *
     * @param string $name the name of the player, default = ""
     */
    public function __construct(string $name = '')
    {
        $this->name = $name;
        $this->hand = new CardHand();
        $this->scoreLow = 0;
        $this->scoreHigh = 0;
        $this->bestScore = 0;
        $this->content = false;
    }

    /**
     * Get the name of the player.
     *
     * @return string as the name of the player
     */
    public function getName(): string
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
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Get the hand of cards of the player.
     *
     * @return CardHand as the hand of cards of the player
     */
    public function getHand(): CardHand
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
    public function increaseHand(Card $card): void
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
    public function setScoreLow(int $scoreLow)
    {
        $this->scoreLow = $scoreLow;
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
    public function setScoreHigh(int $scoreHigh)
    {
        $this->scoreHigh = $scoreHigh;
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
     * Set the bestScore of the player. .
     *
     * @param int $bestScore the scoreHigh of the player
     *
     * @return void
     */
    public function setBestScore(int $bestScore)
    {
        $this->bestScore = $bestScore;
    }

    /**
     * Set the score to the sum of cards in the hand. Ace is counted as 1.
     */
    public function getSumOfHand(): void
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
