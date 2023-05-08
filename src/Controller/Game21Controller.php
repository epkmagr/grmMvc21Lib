<?php

namespace App\Controller;

use App\Card\Deck;
use App\Card\Deck2;
use App\Card\Player;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class Game21Controller extends AbstractController
{
    #[Route("/game", name: "game21", methods: ["GET","HEAD"])]
    public function game21(SessionInterface $session): Response
    {
        $session->clear();
        $deck = new Deck();
        $deck->shuffle();
        $session->set('deck', $deck);

        return $this->render('game21/home.html.twig');
    }

    #[Route("/game/reset", name: "game21Reset", methods: ["GET"])]
    public function game21Reset(SessionInterface $session): Response
    {
        $session->clear();

        return $this->redirectToRoute('game21');
    }

    #[Route("/game/doc", name: "game21Documentation", methods: ["GET"])]
    public function game21Documentation(): Response
    {
        return $this->render('game21/documentation.html.twig');
    }

    /**
     * @Route("/card/deck/deal/{players}/{cards}", name="deal", methods={"GET","POST"})
     * @SuppressWarnings(PHPMD.ElseExpression)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function deal(
        Request $request,
        SessionInterface $session,
        string $players,
        string $cards
    ): Response {
        if ($session->get('deck')) {
            $deck = $session->get('deck');
        } else {
            $deck = new Deck();
            $deck->shuffle();
        }

        $clear = $request->request->get('clear');
        $setup = $request->request->get('setup');
        $deal = $request->request->get('deal');

        $bank = $session->get('bank') ?? new Player('Banken');
        $myPlayers = [];
        $myPlayers = $session->get('myPlayers') ?? [new Player('Spelare 1')];
        $this->setPlayersToContent($myPlayers, $request);
        $gameover = $this->checkIfAllAreContent($bank, $myPlayers);
        $resultStr = '';
        if ($gameover) {
            $resultStr = $this->result($bank, $myPlayers);
        }

        if ($clear) {
            $session->clear();
            $deck = new Deck();
            $deck->shuffle();
            $bank = new Player('Banken');
            $myPlayers = [new Player('Spelare 1')];
            $players = '1';
            $cards = '1';

            return $this->redirectToRoute('deal', ['players' => $players, 'cards' => $cards]);
        } elseif ($setup) {
            $players = $request->request->get('noOfPlayers');
            $cards = $request->request->get('noOfCards');

            for ($i = 0; $i < $players; ++$i) {
                $myPlayers[$i] = new Player('Spelare ' . ($i + 1));
            }
            $session->set('myPlayers', $myPlayers);

            return $this->redirectToRoute('deal', ['players' => $players, 'cards' => $cards]);
        } elseif ($deal) {
            for ($i = 0; $i < $cards; ++$i) {
                if ('' == $bank->getBankResult()) {
                    $card = $deck->getTopCard();
                    $bank->increaseHand($card);
                }
                if ('' !== $bank->getBankResult()) {
                    $bank->setContent();
                }
            }
            $bank->getSumOfHandAceLow();
            $bank->getSumOfHandAceHigh();
            $session->set('bank', $bank);

            for ($i = 0; $i < $cards; ++$i) {
                foreach ($myPlayers as $player) {
                    if ('Nytt kort?' == $player->getPlayerResult() and !$player->isContent()) {
                        $card = $deck->getTopCard();
                        $player->increaseHand($card);
                    }
                }
            }
            foreach ($myPlayers as $player) {
                $player->getSumOfHandAceLow();
                $player->getSumOfHandAceHigh();
            }
            $this->setPlayersToContent($myPlayers, $request);
            $session->set('myPlayers', $myPlayers);
        }

        $session->set('deck', $deck);

        return $this->render('game21/deal.html.twig', [
            'bank' => $bank,
            'myPlayers' => $myPlayers,
            'noOfCardsLeft' => count($deck->getDeck()),
            'result' => $resultStr,
        ]);
    }

    /**
     * @param array<int, Player> $myPlayers the hand of the cards
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    private function setPlayersToContent(array $myPlayers, Request $request)
    {
        foreach ($myPlayers as $i => $player) {
            $name = 'content' . $i;
            $content = $request->request->get($name);
            if ($content) {
                $player->setContent();
            }
        }
    }

    /**
     * @param array<int, Player> $myPlayers the hand of the cards
     */
    private function checkIfAllAreContent(Player $bank, array $myPlayers)
    {
        $noOfContent = 0;

        foreach ($myPlayers as $player) {
            if ($player->isContent()) {
                ++$noOfContent;
            }
        }
        if ($bank->isContent()) {
            ++$noOfContent;
        }

        $total = count($myPlayers) + 1; // bank included

        return $total == $noOfContent ? true : false;
    }

    /**
     * @param array<int, Player> $myPlayers the hand of the cards
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    private function result(Player $bank, array $myPlayers): string
    {
        $result = 'Vinnaren är: ';
        $winner = $bank->getName();
        $bestScore = $bank->getBestScore();
        $noOfCards = $bank->getNoOfCards();
        foreach ($myPlayers as $player) {
            $playerBestScore = $player->getBestScore();
            if ($playerBestScore <= 21 and $playerBestScore > $bestScore) {
                $winner = $player->getName();
                $bestScore = $playerBestScore;
                if ($playerBestScore == $bestScore and $noOfCards > $player->getNoOfCards()) {
                    $winner = $player->getName();
                    $bestScore = $playerBestScore;
                } elseif ($playerBestScore == $bestScore and $noOfCards == $player->getNoOfCards()) {
                    $winner = $winner . ' & ' . $player->getName();
                }
            }
        }

        return $result . '<br>' . $winner;
    }
}
