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
     * @var int      the scoreLow of the player with ace as 1
     * @var int      the scoreHigh of the player with ace as 14
     * @var bool     true if the player is content, false otherwise
     */
    private $name;
    private $hand;
    private $scoreLow;
    private $scoreHigh;

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
        $this->content = false;
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
     * Get the hand of cards of the player.
     *
     * @return CardHand as the hand of cards of the player
     */
    public function gethand()
    {
        return $this->hand;
    }

    /**
     * Set the score to the sum of cards in the hand. Ace is counted as 1.
     *
     * @return int as the sum of the dices in the hand of the player
     */
    public function getSumOfHandAceLow()
    {
        $this->setScoreLow($this->hand->getSumOfHandAceLow());
    }

    /**
     * Get the score to the sum of cards in the hand. Ace is counted as 14.
     *
     * @return int as the sum of the dices in the hand of the player
     */
    public function getSumOfHandAceHigh()
    {
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

    /**
     * Get the result for a player.
     *
     * @return string as the result of the score
     */
    public function getPlayerResult()
    {
        $res = "";
        if ($this->scoreLow == 21 or $this->scoreHigh == 21) {
            $res = "VINST";
            $this->content = true;
        } elseif ($this->scoreLow > 21) {
            $res = "FÖRLUST";
            $this->content = true;
        } else {
            $res = "Nytt kort?";
        }

        return $res;
    }

    /**
     * Get the result for the bank.
     *
     * @return string as the result of the score
     */
    public function getBankResult()
    {
        $res = "";
        if ($this->scoreLow > 21) {
            $res = "FÖRLUST";
            $this->content = true;
        } elseif ($this->scoreLow >= 18 or ($this->scoreHigh >= 18 and $this->scoreHigh <= 21)) {
            $res = "NÖJD";
            $this->content = true;
        } else {
            $res = "";
        }

        return $res;
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
