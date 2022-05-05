<?php

namespace App\Card;

/**
 * Class Card, a class that represents a dice with
 * using a namespace.
 *
 * @author Marie Grahn, grmstud@student.bth.se
 */
class Card
{
    /**
     * @var string $value the value of the card.
     * @var string $suit the suit of the card.
     */
    private $value;
    private $suit;

    /**
     * Constructor to create an object of Dice.
     */
    public function __construct(string $suit, string $value)
    {
        $this->value = $value;
        $this->suit = $suit;
    }

    /**
     * Destroy an object of Dice.
     */
    public function __destruct()
    {
        // echo __METHOD__;
    }

    /**
     * Get the value of the card.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get the suit of the card.
     *
     * @return string
     */
    public function getSuit()
    {
        return $this->suit;
    }
}

// $c = new Card("&hearts;", "7");
// var_dump($c);
// echo $c->getValue();
// echo $c->getSuit();
