<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\HttpFoundation\RequestStack;

class CardController extends AbstractController
{
    // private $session =  new Session();
    // $session->setId('123456');
    // $session->start();

    /**
     * @Route("/card", name="card")
     */
    public function card(): Response
    {
        return $this->render('card/card.html.twig');
    }

    /**
     * @Route("/card/deck", name="deck")
     */
    public function deck(): Response
    {
        $deck = new \App\Card\Deck();
        // $session->set('deck', $deck->getDeck());

        return $this->render('card/deck.html.twig', [
            'deck' => $deck->getDeck(),
        ]);
    }

    /**
     * @Route("/card/deck/shuffle", name="shuffle")
     */
    public function shuffle(): Response
    {
        // $deck = $session->get('deck');
        $deck = new \App\Card\Deck();
        $deck->shuffle();

        return $this->render('card/deck.html.twig', [
            'deck' => $deck->getDeck(),
        ]);
    }

    /**
     * @Route("/card/deck/draw", name="draw")
     */
    public function draw(): Response
    {
        // $deck = $session->get('deck');
        $deck = new \App\Card\Deck();
        $deck->shuffle();
        $noOfCards = count($deck->getDeck());
        $number = random_int(0, $noOfCards);

        return $this->render('card/draw.html.twig', [
            'card' => $deck->getCard($number),
            'noOfCardsLeft' => $noOfCards - 1,
        ]);
    }

    /**
     * @Route("/card/deck/draw/:{cardNumber}", name="drawNumber")
     */
    public function drawNumber(string $cardNumber): Response
    {
        // $deck = $session->get('deck');
        $deck = new \App\Card\Deck();
        $noOfCards = count($deck->getDeck());

        return $this->render('card/draw.html.twig', [
            'card' => $deck->getCard($cardNumber),
            'noOfCardsLeft' => $noOfCards - 1,
        ]);
    }
}
