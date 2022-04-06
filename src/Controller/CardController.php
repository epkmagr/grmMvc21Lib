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

    /**
     * @Route("/card/deck/draw", name="draw", methods={"GET","POST"})
     */
    public function draw(Request $request, SessionInterface $session): Response
    {
        $deck = $session->get('deck') ?? new \App\Card\Deck();
        $deck->shuffle();

        $draw = $request->request->get('draw');
        $clear = $request->request->get('clear');

        if ($draw) {
            $cards[] = $deck->getTopCard();
        } elseif ($clear) {
            $deck = new \App\Card\Deck();
        }

        $noOfCards = count($deck->getDeck());
        $session->set('deck', $deck);

        return $this->render('card/draw.html.twig', [
            'cards' => $cards ?? NULL,
            'noOfCardsLeft' => count($deck->getDeck()),
        ]);
    }

    /**
     * @Route("/card/deck/draw/:{number}", name="drawSeveral", methods={"GET","POST"})
     */
    public function drawSeveral(Request $request, SessionInterface $session, string $number="1"): Response
    {
        if ($session->get('deck')) {
            $deck = $session->get('deck');
        } else {
            $deck = new \App\Card\Deck();
            $deck->shuffle();
        }

        $clear = $request->request->get('clear');
        $drawSeveral = $request->request->get('drawSeveral');
        $noOfCards =$number;

        if ($clear) {
            $session->clear();
            $deck = new \App\Card\Deck();
            $deck->shuffle();
        } elseif ($drawSeveral) {
            $noOfCards = intval($request->request->get('noOfCards'));
            for ($i = 0; $i < $noOfCards; $i++) {
                $cards[] = $deck->getTopCard();
            }
        }

        $noOfCards = count($deck->getDeck());
        $session->set('deck', $deck);

        return $this->render('card/drawSeveral.html.twig', [
            'cards' => $cards ?? NULL,
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
     * @Route("/card/deck/deal/:{players}/:{cards}", name="deal", methods={"GET","POST"})
     */
    public function deal(Request $request, SessionInterface $session,
        string $players = '1', string $cards = '1'): Response
    {
        if ($session->get('deck')) {
            $deck = $session->get('deck');
        } else {
            $deck = new \App\Card\Deck();
            $deck->shuffle();
        }

        $clear = $request->request->get('clear');
        $setup = $request->request->get('setup');
        $deal = $request->request->get('deal');

        $bank = $session->get('bank') ?? new \App\Card\Player('Banken');
        $myPlayers = $session->get('myPlayers') ?? new \App\Card\Player('Spelare 1');

        if ($clear) {
            $session->clear();
            $deck = new \App\Card\Deck();
            $deck->shuffle();
            $bank = new \App\Card\Player('Banken');
            $myPlayers =  new \App\Card\Player('Spelare 1');
        } elseif ($setup) {
            $players = $request->request->get('noOfPlayers') ?? "1";
            $cards = $request->request->get('noOfCards') ?? "1";
            // $this->generateUrl('deal', array('players'=>$players, 'cards'=>$cards));
            return $this->redirectToRoute('deal', ['players'=>$players, 'cards'=>$cards]);
        } elseif ($deal) {
            for ($i = 0; $i < $cards; $i++) {
                $card = $deck->getTopCard();
                $bank->increaseHand($card);
            }
            $bank->getSumOfHandAceLow();
            $session->set('bank', $bank);

            for ($i = 0; $i < $cards; $i++) {
                $card = $deck->getTopCard();
                $myPlayers->increaseHand($card);
            }
            $myPlayers->getSumOfHandAceLow();
            $session->set('myPlayers', $myPlayers);
        }

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
