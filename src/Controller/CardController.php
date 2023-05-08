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

class CardController extends AbstractController
{
    #[Route("/card", name: "card", methods: ["GET","HEAD"])]
    public function card(SessionInterface $session): Response
    {
        $deck = $session->get('deck') ?? new Deck();
        $session->set('deck', $deck);
        $deck2 = $session->get('deck2') ?? new Deck2();
        $session->set('deck2', $deck2);

        return $this->render('card/card.html.twig');
    }

    #[Route("/card/reset", name: "cardReset", methods: ["GET"])]
    public function cardReset(SessionInterface $session): Response
    {
        $session->clear();

        return $this->redirectToRoute('card');
    }

    #[Route("/card/deck", name: "deck", methods: ["GET"])]
    public function deck(SessionInterface $session): Response
    {
        $deck = $session->get('deck');

        return $this->render('card/deck.html.twig', [
            'deck' => $deck->getDeck(),
        ]);
    }

    #[Route("/card/deck2", name: "deck2", methods: ["GET"])]
    public function deck2(SessionInterface $session): Response
    {
        $deck2 = $session->get('deck2');

        return $this->render('card/deck.html.twig', [
            'deck' => $deck2->getDeck(),
        ]);
    }

    #[Route("/card/deck/shuffle", name: "shuffle", methods: ["GET"])]
    public function shuffle(SessionInterface $session): Response
    {
        $deck = $session->get('deck');
        $deck->shuffle();
        $session->set('deck', $deck);

        return $this->render('card/deck.html.twig', [
            'deck' => $deck->getDeck(),
        ]);
    }

    #[Route("/card/deck/draw", name: "draw", methods: ["GET","POST"])]
    public function draw(Request $request, SessionInterface $session): Response
    {
        $cards = array();
        $deck = $session->get('deck');

        $draw = $request->request->get('draw');
        $clear = $request->request->get('clear');

        if ($draw) {
            if (count($deck->getDeck()) > 0) {
                $cards[] = $deck->getTopCard();
            }
        } elseif ($clear) {
            $deck = new Deck();
            $deck->shuffle();
        }

        $session->set('deck', $deck);

        return $this->render('card/draw.html.twig', [
            'cards' => $cards,
            'noOfCardsLeft' => count($deck->getDeck()),
        ]);
    }

    /** @SuppressWarnings(PHPMD.ElseExpression) */
    #[Route("/card/deck/draw/{number}", name: "drawSeveral", methods: ["GET","POST"])]
    public function drawSeveral(Request $request, SessionInterface $session): Response
    {
        $cards = array();

        if ($session->get('deck')) {
            $deck = $session->get('deck');
        } else {
            $deck = new Deck();
            $deck->shuffle();
        }

        $clear = $request->request->get('clear');
        $drawSeveral = $request->request->get('drawSeveral');

        if ($clear) {
            $session->clear();
            $deck = new Deck();
            $deck->shuffle();
        } elseif ($drawSeveral) {
            $noOfCards = intval($request->request->get('noOfCards'));
            $noOfCardsLeft = count($deck->getDeck());
            $noOfCardsToGet = ($noOfCardsLeft >= $noOfCards) ? $noOfCards : $noOfCardsLeft;
            for ($i = 0; $i < $noOfCardsToGet; ++$i) {
                $cards[] = $deck->getTopCard();
            }
            $request->attributes->set('number', $noOfCards);
        }

        $session->set('deck', $deck);

        return $this->render('card/drawSeveral.html.twig', [
            'cards' => $cards,
            'noOfCardsLeft' => count($deck->getDeck()),
        ]);
    }
}
