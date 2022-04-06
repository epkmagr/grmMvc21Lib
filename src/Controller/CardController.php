<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    /**
     * @Route("/card", name="card", methods={"GET","HEAD"})
     */
    public function card(SessionInterface $session): Response
    {
        $session->clear();

        return $this->render('card/card.html.twig');
    }

    /**
     * @Route("/card/deck", name="deck", methods={"GET"})
     */
    public function deck(SessionInterface $session): Response
    {
        $deck = new \App\Card\Deck();
        $session->set('deck', $deck);

        return $this->render('card/deck.html.twig', [
            'deck' => $deck->getDeck(),
        ]);
    }

    /**
     * @Route("/card/deck/shuffle", name="shuffle", methods={"GET"})
     */
    public function shuffle(SessionInterface $session): Response
    {
        $deck = new \App\Card\Deck();
        $deck->shuffle();

        $session->set('deck', $deck);

        return $this->render('card/deck.html.twig', [
            'deck' => $deck->getDeck(),
        ]);
    }

    // /**
    //  * @Route("/card/deck/reset", name="reset")
    //  */
    // public function reset(SessionInterface $session): Response
    // {
    //     $deck = new \App\Card\Deck();
    //     $deck->shuffle();
    //
    //     $noOfCards = count($deck->getDeck());
    //     $number = random_int(0, $noOfCards);
    //     $card = $deck->getCard($number);
    //     $session->set('deck', $deck);
    //
    //     return $this->render('card/draw.html.twig', [
    //         'card' => $card,
    //         'noOfCardsLeft' => count($deck->getDeck()),
    //     ]);
    // }

    /**
     * @Route("/card/deck/draw", name="draw", methods={"GET","POST"})
     */
    public function draw(Request $request, SessionInterface $session): Response
    {
        $deck = $session->get('deck') ?? new \App\Card\Deck();
        $deck->shuffle();

        $draw = $request->request->get('draw');
        $clear = $request->request->get('clear');
        $drawSeveral = $request->request->get('drawSeveral');

        if ($draw) {
            $cards[] = $deck->getTopCard();
        } elseif ($clear) {
            $deck = new \App\Card\Deck();
        } elseif ($drawSeveral) {
            $noOfCards = intval($request->request->get('noOfCards'));
            for ($i = 0; $i < $noOfCards; $i++) {
                $cards[] = $deck->getTopCard();
            }
        }

        $noOfCards = count($deck->getDeck());
        $session->set('deck', $deck);

        return $this->render('card/draw.html.twig', [
            'cards' => $cards ?? NULL,
            'noOfCardsLeft' => count($deck->getDeck()),
        ]);
    }

    /**
     * @Route("/card/deck/draw/:{cardNumber}", name="drawNumber")
     */
    public function drawNumber(SessionInterface $session, string $cardNumber): Response
    {
        $deck = $session->get('deck') ?? new \App\Card\Deck();

        $noOfCards = count($deck->getDeck());
        $card = $deck->getCard($cardNumber);
        $session->set('deck', $deck);

        return $this->render('card/draw.html.twig', [
            'card' => $card,
            'noOfCardsLeft' => count($deck->getDeck()),
        ]);
    }

    /**
     * @Route("/game/card", name="documentation")
     */
    public function documentation(): Response
    {
        return $this->render('card/documentation.html.twig');
    }

    /**
     * @Route("/card/deck/deal/:{players}/:{cards}", name="deal")
     */
    public function deal(SessionInterface $session, string $players = '1', string $cards = '1'): Response
    {
        $deck = $session->get('deck') ?? new \App\Card\Deck();
        $deck->shuffle();

        $bank = $session->get('bank');
        if (!isset($bank)) {
            $bank = new \App\Card\Player('Banken');
        }
        $card = $deck->getTopCard();
        $bank->increaseHand($card);
        $bank->getSumOfHandAceLow();
        $session->set('bank', $bank);

        $myPlayers = $session->get('myPlayers');
        if (!isset($myPlayers)) {
            $myPlayers = new \App\Card\Player('Spelare 1');
        }

        $card = $deck->getTopCard();
        $myPlayers->increaseHand($card);
        $myPlayers->getSumOfHandAceLow();
        $session->set('myPlayers', $myPlayers);
        // $myPlayers = $this->createPlayers($players, $cards, $deck);
        $noOfCards = count($deck->getDeck());
        $session->set('deck', $deck);

        return $this->render('card/deal.html.twig', [
            'bank' => $bank,
            'myPlayers' => $myPlayers,
            'noOfCardsLeft' => count($deck->getDeck()),
        ]);
    }

    /**
     * @Route("/card/deck/resetDeal/:{players}/:{cards}", name="resetDeal")
     */
    public function resetDeal(SessionInterface $session, string $players = '1', string $cards = '1'): Response
    {
        $deck = new \App\Card\Deck();
        $deck->shuffle();

        $bank = new \App\Card\Player('Banken');
        $card = $deck->getTopCard();
        $bank->increaseHand($card);
        $bank->getSumOfHandAceLow();
        $session->set('bank', $bank);

        $myPlayers = new \App\Card\Player('Spelare 1');
        $card = $deck->getTopCard();
        $myPlayers->increaseHand($card);
        $myPlayers->getSumOfHandAceLow();
        $session->set('myPlayers', $myPlayers);
        // $myPlayers = $this->createPlayers($players, $cards, $deck);
        $noOfCards = count($deck->getDeck());
        $session->set('deck', $deck);

        return $this->render('card/deal.html.twig', [
            'bank' => $bank,
            'myPlayers' => $myPlayers,
            'noOfCardsLeft' => count($deck->getDeck()),
        ]);
    }

    // private function createPlayers(string $players, string $cards = "1", \App\Card\Deck $deck)
    // {
    //     $myPlayers = [];
    //
    //     for ($i = 0; $i < intval($players); $i++) {
    //         $myPlayers[] = new \App\Card\Player("Spelare " . $i);
    //         $myPlayers[] = $myPlayers[$i]->increaseHand($deck);
    //     }
    //
    //     return $myPlayers;
    // }
}
