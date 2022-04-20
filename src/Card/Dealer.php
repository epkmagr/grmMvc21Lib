<?php

namespace App\Card;

/**
 *Class Dealer represents a dealer in card game 21.
 *
 * @author Marie Grahn, mbfs17@student.bth.se
 */
class Dealer extends Participant
{
    /**
     * Constructor to initiate the dicehand with a number of dices.
     *
     * @param string $name the name of the player, default = ""
     */
    public function __construct(string $name = '')
    {
        parent::__construct($name);
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
     * Get the result for the bank.
     *
     * @return string as the result of the score
     */
    public function getResult()
    {
        $res = '';
        if ($this->scoreLow > 21) {
            $res = 'FÖRLUST';
            $this->content = true;
            $this->bestScore = 0;
        } elseif ($this->scoreLow >= 18) {
            $res = 'NÖJD';
            $this->content = true;
            $this->bestScore = $this->scoreLow;
        } elseif ($this->scoreHigh >= 18 and $this->scoreHigh <= 21) {
            $res = 'NÖJD';
            $this->content = true;
            $this->bestScore = $this->scoreHigh;
        } else {
            $res = '';
            if ($this->scoreHigh > $this->scoreLow) {
                $this->bestScore = $this->scoreHigh;
            } else {
                $this->bestScore = $this->scoreLow;
            }
        }

        return $res;
    }
}
