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
     * @Route("/card/deck2", name="deck2", methods={"GET"})
     */
    public function deck2(SessionInterface $session): Response
    {
        $deck2 = new \App\Card\Deck2();
        $session->set('deck2', $deck2);

        return $this->render('card/deck.html.twig', [
            'deck' => $deck2->getDeck(),
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
    public function drawSeveral(Request $request, SessionInterface $session, string $number): Response
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
            $request->attributes->set('number', $noOfCards);

            // return $this->redirectToRoute('drawSeveral', ['number'=>$noOfCards]);
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
        string $players, string $cards): Response
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
        $myPlayers = [];
        $myPlayers = $session->get('myPlayers') ?? [new \App\Card\Player('Spelare 1')];

        if ($clear) {
            $session->clear();
            $deck = new \App\Card\Deck();
            $deck->shuffle();
            $bank = new \App\Card\Player('Banken');
            $myPlayers = [new \App\Card\Player('Spelare 1')];
            $players = "1";
            $cards = "1";

            return $this->redirectToRoute('deal', ['players'=>$players, 'cards'=>$cards]);
        } elseif ($setup) {
            $players = $request->request->get('noOfPlayers');
            $cards = $request->request->get('noOfCards');

            for ($i = 0; $i < $players; $i++) {
                $myPlayers[$i] = new \App\Card\Player('Spelare ' . ($i + 1));
            }
            $session->set('myPlayers', $myPlayers);

            return $this->redirectToRoute('deal', ['players'=>$players, 'cards'=>$cards]);
        } elseif ($deal) {
            for ($i = 0; $i < $cards; $i++) {
                $card = $deck->getTopCard();
                $bank->increaseHand($card);
            }
            $bank->getSumOfHandAceLow();
            $session->set('bank', $bank);

            for ($i = 0; $i < $cards; $i++) {
                foreach ($myPlayers as $player) {
                    $card = $deck->getTopCard();
                    $player->increaseHand($card);
                }
            }
            foreach ($myPlayers as $player) {
                $player->getSumOfHandAceLow();
            }
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

    private function createPlayers(string $players, string $cards = "1", \App\Card\Deck $deck)
    {
        $myPlayers = [];

        for ($i = 0; $i < intval($players); $i++) {
            $myPlayers[] = new \App\Card\Player("Spelare " . $i);
            $myPlayers[] = $myPlayers[$i]->increaseHand($deck);
        }

        return $myPlayers;
    }
}
