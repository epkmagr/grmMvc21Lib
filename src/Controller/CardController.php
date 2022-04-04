<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
// use Symfony\Component\HttpFoundation\Session\Session;

// $session =  new Session();
// $session->setId('123456');
// $session->start();

class CardController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

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
        $session = $this->requestStack->getSession();
        $this->session->set('deck', deck);

        return $this->render('card/deck.html.twig', [
            'deck' => $deck->getDeck(),
        ]);
    }

    /**
     * @Route("/card/deck/shuffle", name="shuffle")
     */
    public function shuffle(): Response
    {
        $deck = new \App\Card\Deck();
        $deck->shuffle();

        $session = $this->requestStack->getSession();
        $session->set('deck', $deck);

        return $this->render('card/deck.html.twig', [
            'deck' => $deck->getDeck(),
        ]);
    }

    /**
     * @Route("/card/deck/reset", name="reset")
     */
    public function reset(): Response
    {
        $deck = new \App\Card\Deck();
        $deck->shuffle();

        $noOfCards = count($deck->getDeck());
        $number = random_int(0, $noOfCards);
        $card = $deck->getCard($number);
        $session = $this->requestStack->getSession();
        $session->set('deck', $deck);

        return $this->render('card/draw.html.twig', [
            'card' => $card,
            'noOfCardsLeft' => count($deck->getDeck()),
        ]);
    }

    /**
     * @Route("/card/deck/draw", name="draw")
     */
    public function draw(RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();
        $deck = $session->get('deck');
        if (!isset($deck)) {
            $deck = new \App\Card\Deck();
        }
        $noOfCards = count($deck->getDeck());
        $number = random_int(0, $noOfCards);
        $card = $deck->getCard($number);
        $session->set('deck', $deck);

        return $this->render('card/draw.html.twig', [
            'card' => $card,
            'noOfCardsLeft' => count($deck->getDeck()),
        ]);
    }

    /**
     * @Route("/card/deck/draw/:{cardNumber}", name="drawNumber")
     */
    public function drawNumber(RequestStack $requestStack, string $cardNumber): Response
    {
        $session = $requestStack->getSession();
        $deck = $session->get('deck');
        if (!isset($deck)) {
            $deck = new \App\Card\Deck();
        }
        $noOfCards = count($deck->getDeck());
        $card = $deck->getCard($cardNumber);
        $session->set('deck', $deck);

        return $this->render('card/draw.html.twig', [
            'card' => $card,
            'noOfCardsLeft' => count($deck->getDeck()),
        ]);
    }
}
