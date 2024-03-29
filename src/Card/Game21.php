<?php

namespace App\Card;

/**
 * Class Game21 represents the card game 21.
 *
 * @author Marie Grahn, grmstud@student.bth.se
 *
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class Game21
{
    public const MAX_PLAYERS = 4;
    public const MAX_CARDS = 3;

    /**
     * @var Deck $deck the hand of the cards
     */
    private $deck;
    /**
     * @var Dealer $dealer the hand of the cards
     */
    private $dealer;
    /**
     * @var array<int, Player21> $players the hand of the cards
     */
    private $players;

    /**
     * * @var int    the number of players, default 1, max 4
     */
    private int $noOfPlayers;

    /**
     * @var int    the number of cards to draw per round,
     *             default 1, max 3
     */
    private int $noOfCards;

    /**
     * * @var bool    true if the game is over, false otherwise
     */
    private bool $gameover;

    /**
     * * @var string    the name of the winner
     */
    private string $winner;

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
        $this->gameover = false;
        $this->winner = "";
    }

    /**
     * Destroy an object of Dice.
     */
    public function __destruct()
    {
        // echo __METHOD__;
    }

    /**
     * Get the number of players in the game.
     *
     * @return int
     */
    public function getNoOfPlayers(): int
    {
        return $this->noOfPlayers;
    }

    /**
     * Get the deck of the cards.
     *
     * @return int
     */
    public function getNoOfCards(): int
    {
        return $this->noOfCards;
    }

    /**
     * Get the deck of the cards.
     *
     * @return Deck
     */
    public function getDeck(): Deck
    {
        return $this->deck;
    }

    /**
     * Get the dealer or bank.
     *
     * @return Dealer
     */
    public function getDealer(): Dealer
    {
        return $this->dealer;
    }

    /**
     * Get the players.
     *
     * @return array<int, Player21>
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * Get true if the game is over, false otherwise.
     *
     * @return bool
     */
    public function isItGameover(): bool
    {
        //$gameover = false;
        if ($this->checkIfPlayersAreContent() and $this->dealer->isContent()) {
            $this->gameover = true;
        }

        return $this->gameover;
    }

    /**
     * Get the name of the winner.
     *
     * @return string
     */
    public function getWinner(): string
    {
        return $this->winner;
    }

    /**
     * Resets the game.
     *
     * @return void
     */
    public function reset(): void
    {
        $this->deck = new Deck();
        $this->dealer = new Dealer('Banken');
        $this->players = [new Player21('Spelare 1')];
        $this->gameover = false;
        $this->winner = "";
        if ($this->noOfPlayers > 1) {
            $this->initGame($this->noOfPlayers, $this->noOfCards);
        }
    }

    /**
     * Initiate the game, shuffle the deck of cards. Set the number of players and
     * the number of cards to draw per round.
     *
     * @param int $players the number of players, default 1, max 4
     * @param int $cards the number of cards to draw per round,
     *          default 1, max 3
     *
     * @return void
     */
    public function initGame(int $players=1, int $cards=1): void
    {
        $this->deck->shuffle();
        $this->noOfPlayers = $players > self::MAX_PLAYERS ? self::MAX_PLAYERS : $players;
        for ($i = 0; $i < $this->noOfPlayers; ++$i) {
            $this->players[$i] = new Player21('Spelare ' . ($i + 1));
        }
        $this->noOfCards = $cards > self::MAX_CARDS ? self::MAX_CARDS : $cards;
    }

    /**
     * Play the game.
     * @SuppressWarnings(PHPMD.ElseExpression)
     *
     * @return string the result of the game, if any
     */
    public function play(): string
    {
        $result = '';

        // Play the game
        // Let the players play first
        if (!$this->checkIfPlayersAreContent()) {
            $this->playPlayers();
        }

        // Calculate the result and return it
        if ($this->checkIfPlayersAreContent()) {
            // Let the dealer play when all the player are content
            while (! $this->dealer->isContent()) {
                $this->dealer->play($this->noOfCards, $this->deck);
            }
            $result = $this->result();
        }

        return $result;
    }

    private function playPlayers(): void
    {
        for ($i = 0; $i < $this->noOfCards; ++$i) {
            foreach ($this->players as $player) {
                $player->play($this->deck);
            }
        }
        foreach ($this->players as $player) {
            $player->getSumOfHand();
            $player->getResult();
        }
    }

    public function getAllPlayersInfo()
    {
        $allPlayersInfo = array();
        // Add info about the dealer
        $playerInfo = array();
        $playerInfo['name'] = $this->dealer->getName();
        $playerInfo['cards'] = $this->dealer->getHand()->getCards();
        $playerInfo['cards'] = $this->dealer->getHand()->getCardsJson();
        $playerInfo['sum low/high'] = $this->dealer->getScoreLow() . '/' . $this->dealer->getScoreHigh();
        $playerInfo['result'] = $this->dealer->getResult();
        array_push($allPlayersInfo, $playerInfo);
        // Add info about all the players
        foreach ($this->players as $player) {
            $playerInfo = array();
            $playerInfo['name'] = $player->getName();
            $playerInfo['cards'] = $player->getHand()->getCards();
            $playerInfo['cards'] = $player->getHand()->getCardsJson();
            $playerInfo['sum low/high'] = $player->getScoreLow() . '/' . $player->getScoreHigh();
            $playerInfo['result'] = $player->getResult();
            array_push($allPlayersInfo, $playerInfo);
        }

        return $allPlayersInfo;
    }

    private function checkIfPlayersAreContent(): bool
    {
        $noOfContent = 0;

        foreach ($this->players as $player) {
            if ($player->isContent()) {
                ++$noOfContent;
            }
        }
        $total = count($this->players);

        return $total === $noOfContent ? true : false;
    }

    /**
    * returns the result of the game
    */
    public function result(): string
    {
        $winner = $this->dealer->getName();
        $dealerScore = $this->dealer->getBestScore();
        $playerBestScore = 0;
        foreach ($this->players as $player) {
            $playerScore = $player->getBestScore();
            if ($playerScore > $playerBestScore) {
                $playerBestScore = $player->getBestScore();
                if ($playerBestScore <= 21 and $playerBestScore > $dealerScore or $dealerScore > 21) {
                    $winner = $player->getName();
                }
            } elseif ($playerScore === $playerBestScore and $playerScore <= 21 and $playerScore > $dealerScore) {
                $winner .= ' & ' . $player->getName();
            }
        }
        $this->winner = $winner;

        return 'Vinnaren är: ' . '<br>' . $winner;
    }

    public function getJsonData()
    {
        $data = [
            'no of players' => $this->getNoOfPlayers(),
            'no of cards to draw' => $this->getNoOfCards(),
            'Players info' => $this->getAllPlayersInfo(),
            'remaining cards' => $this->getDeck()->getNoOfCards(),
            'the winner is' => $this->getWinner()
        ];

        return $data;
    }
}
