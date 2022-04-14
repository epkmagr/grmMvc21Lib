<?php

namespace App\Card;

use \App\Card\Deck;
use \App\Card\Dealer;
use \App\Card\Player21;

/**
 * Class Card, a class that represents a dice with
 * using a namespace.
 *
 * @author Marie Grahn, grmstud@student.bth.se
 */
class Game21
{
    const MAX_PLAYERS = 4;
    const MAX_CARDS = 3;

    /**
     * @var Deck    $deck the deck of cards
     * @var Dealer  $dealer the dealer
     * @var array   $players the array with Player21 objects
     * @var int     $noOfPlayers the number of players, default 1, max 4.
     * @var int     $noOfCards the number of cards to draw per round,
     *              default 1, max 3.
     */
    private $deck;
    private $dealer;
    private $players;
    private $noOfPlayers;
    private $noOfCards;

    /**
     * Constructor to create an object of Game 21 with one dealer, one player,
     * and one card to draw.
     */
    public function __construct()
    {
        $this->deck = new Deck();
        $this->dealer = new Dealer('Banken');
        $this->players = [new Player21('Spelare 1')];
        $this->noOfPlayers = 1;
        $this->noOfCards = 1;
    }

    /**
     * Destroy an object of Dice.
     */
    public function __destruct()
    {
        // echo __METHOD__;
    }

    /**
     * Get the deck of the cards.
     *
     * @return Deck
     */
    public function getDeck()
    {
        return $this->deck->getDeck();
    }

    /**
     * Get the dealer or bank.
     *
     * @return Dealer
     */
    public function getDealer()
    {
        return $this->dealer;
    }

    /**
     * Get the players.
     *
     * @return array
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * Initiate the game, shuffle the deck of cards. Set the number of players and
     * the number of cards to draw per round.
     *
     * @var int     $players the number of players, default 1, max 4.
     * @var int     $cards the number of cards to draw per round,
     *              default 1, max 3.
     *
     * @return void
     */
    public function initGame(int $players = 1, int $cards = 1)
    {
        $this->deck->shuffle();
        $this->noOfPlayers = $players > self::MAX_PLAYERS ? self::MAX_PLAYERS : $players;
        for ($i = 0; $i < $this->noOfPlayers; ++$i) {
            $this->players[$i] = new Player21('Spelare '.($i + 1));
        }
        $this->noOfCards = $cards > self::MAX_CARDS ? self::MAX_CARDS : $cards;
    }

    /**
     * Play the game
     *
     * @return string the result of the game, if any
     */
    public function play()
    {
        $result = "";

        // Play the game
        // Let the players play first
        $this->playPlayers();
        // Let the dealer play
        $this->playDealer();
        // Calculate the result and return it
        if ($this->checkIfAllAreContent()) {
            $result = $this->result();
        }

        return $result;
    }

    private function playPlayers() {
        for ($i = 0; $i < $this->noOfCards; ++$i) {
            foreach ($this->players as $player) {
                if ('Nytt kort?' == $player->getResult() and !$player->isContent()) {
                    $card = $this->deck->getTopCard();
                    $player->increaseHand($card);
                }
            }
        }
        foreach ($this->players as $player) {
            $player->getSumOfHand();
        }
    }

    private function playDealer() {
        for ($i = 0; $i < $this->noOfCards; ++$i) {
            if ('' == $this->dealer->getResult()) {
                $card = $this->deck->getTopCard();
                $this->dealer->increaseHand($card);
            }
            if ('' !== $this->dealer->getResult()) {
                $this->dealer->setContent();
            }
        }
        $this->dealer->getSumOfHand();
    }

    private function checkIfAllAreContent()
    {
        $noOfContent = 0;

        for ($i = 0; $i < count($this->players); ++$i) {
        }
        foreach ($this->players as $player) {
            if ($player->isContent()) {
                ++$noOfContent;
            }
        }
        if ($this->dealer->isContent()) {
            ++$noOfContent;
        }

        $total = count($this->players) + 1; // dealer included

        return $total == $noOfContent ? true : false;
    }

    public function result()
    {
        $result = 'Vinnaren är: ';
        $winner = $this->dealer->getName();
        $bestScore = $this->dealer->getBestScore();
        $noOfCards = $this->dealer->getNoOfCards();
        for ($i = 0; $i < count($this->players); ++$i) {
            $playerBestScore = $this->players[$i]->getBestScore();
            if ($playerBestScore <= 21 and $playerBestScore > $bestScore) {
                if ($playerBestScore == $bestScore and $noOfCards > $this->players[$i]->getNoOfCards()) {
                    $winner = $this->players[$i]->getName();
                    $bestScore = $playerBestScore;
                } elseif ($playerBestScore == $bestScore and $noOfCards == $this->players[$i]->getNoOfCards()) {
                    $winner = $winner.' & '.$this->players[$i]->getName();
                } else {
                    $winner = $this->players[$i]->getName();
                    $bestScore = $playerBestScore;
                }
            }
        }

        return $result.'<br>'.$winner;
    }
}

// $c = new Card("&hearts;", "7");
// var_dump($c);
// echo $c->getValue();
// echo $c->getSuit();
