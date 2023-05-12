<?php

namespace App\Card;

/**
 * Class Player21 represents a player in card game 21.
 *
 * @author Marie Grahn, mbfs17@student.bth.se
 */
class Player21 extends Participant
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
     * Get the best score of the player.
     *
     * @return void
     */
    public function play($deck)
    {
        if ('Nytt kort?' == $this->getResult() and !$this->isContent()) {
            $card = $deck->getTopCard();
            if ($card) {
                $this->increaseHand($card);
            }
        }
    }

    /**
     * Get the result for a player.
     * @SuppressWarnings(PHPMD.ElseExpression)
     *
     * @return string as the result of the score
     */
    public function getResult()
    {
        $res = '';
        if (21 == $this->scoreLow) {
            $res = 'NÖJD';
            $this->content = true;
            $this->bestScore = $this->scoreLow;
        } elseif (21 == $this->scoreHigh) {
            $res = 'NÖJD';
            $this->content = true;
            $this->bestScore = $this->scoreHigh;
        } elseif ($this->scoreLow > 21) {
            $res = 'FÖRLUST';
            $this->content = true;
            $this->bestScore = 0;
        } else {
            $res = 'Nytt kort?';
            if ($this->scoreHigh > $this->scoreLow) {
                $this->bestScore = $this->scoreLow;
            } else {
                $this->bestScore = $this->scoreHigh;
            }
        }

        return $res;
    }
}
