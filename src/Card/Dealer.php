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
     * Play the bank.
     *
     * @return void
     */
    public function play($noOfCards, $deck): void
    {
        for ($i = 0; $i < $noOfCards; ++$i) {
            if ('' == $this->getResult()) {
                $card = $deck->getTopCard();
                if ($card) {
                    $this->increaseHand($card);
                }
            }
            if ('' !== $this->getResult()) {
                $this->setContent();
            }
        }
        $this->getSumOfHand();
    }

    /**
     * Get the result for the bank.
     * @SuppressWarnings(PHPMD.ElseExpression)
     *
     * @return string as the result of the score
     */
    public function getResult()
    {
        if ($this->scoreLow > 21) {
            $this->content = true;
            $this->bestScore = 0;
            return 'FÖRLUST';
        } elseif ($this->scoreLow >= 18) {
            $this->content = true;
            $this->bestScore = $this->scoreLow;
            return 'NÖJD';
        } elseif ($this->scoreHigh >= 18 and $this->scoreHigh <= 21) {
            $this->content = true;
            $this->bestScore = $this->scoreHigh;
            return 'NÖJD';
        }
        $this->bestScore = max($this->scoreLow, $this->scoreHigh);

        return '';
    }
}
