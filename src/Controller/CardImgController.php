<?php

namespace App\Controller;

use App\Card\Deck;
use Player;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardImgController extends AbstractController
{
    #[Route("/card/deckImg", name: "deckImg", methods: ["GET"])]
    public function deckImg(SessionInterface $session): Response
    {
        $deck = $session->get('deck') ?? new Deck();
        $cardsImg = $deck->sortDeck();
        $data = [
            'title' => 'Kortlek med bilder',
            'deck' => $cardsImg
        ];
        $session->set('deck', $deck);

        return $this->render('card/deckImg.html.twig', $data);
    }

    #[Route("/card/deck/shuffleImg", name: "shuffleImg", methods: ["POST"])]
    public function shuffleImg(SessionInterface $session): Response
    {
        $deck = $session->get('deck');
        $deck->shuffle();
        $session->set('deck', $deck);

        return $this->redirectToRoute('shuffleImgShow');
    }

    #[Route("/card/deck/shuffleImg", name: "shuffleImgShow", methods: ["GET"])]
    public function shuffleImgShow(SessionInterface $session): Response
    {
        $deck = $session->get('deck');
        $cardsImg = [];

        foreach ($deck->getDeck() as $card) {
            array_push($cardsImg, $card->getImgUrl());
        }
        $data = [
            'title' => 'Blandad kortlek med bilder',
            'deck' => $cardsImg
        ];

        return $this->render('card/deckImg.html.twig', $data);
    }

    #[Route("/card/deck/drawImg", name: "drawImg", methods: ["POST"])]
    public function drawImg(): Response
    {
        return $this->redirectToRoute('drawImgShow');
    }

    #[Route("/card/deck/drawImg", name: "drawImgShow", methods: ["GET"])]
    public function drawImgShow(SessionInterface $session): Response
    {
        $cards = array();
        $deck = $session->get('deck');

        if (count($deck->getDeck()) > 0) {
            $cards = $deck->getTopCard()->getImgUrl();
        }

        $data = [
            'title' => 'Blandad kortlek med bilder, dra ett kort',
            'noOfCardsLeft' => count($deck->getDeck()),
            'deck' => $cards
        ];

        $session->set('deck', $deck);

        return $this->render('card/drawImg.html.twig', $data);
    }

    #[Route("/card/deck/drawImg/{number}", name: "drawSeveralImg", methods: ["POST"])]
    public function drawSeveralImg(Request $request, SessionInterface $session): Response
    {
        $session->set("noOfCards", $request->request->get('number'));

        return $this->redirectToRoute('drawSeveralImgShow', array('number' => intval($request->request->get('number'))));
    }

    #[Route("/card/deck/drawImg/{number}", name: "drawSeveralImgShow", methods: ["GET"])]
    public function drawSeveralImgShow(SessionInterface $session): Response
    {
        $cardsImg = [];
        $cards = array();

        $deck = $session->get('deck');
        $noOfCards = intval($session->get('noOfCards'));
        $noOfCardsLeft = count($deck->getDeck());
        $noOfCardsToGet = ($noOfCardsLeft >= $noOfCards) ? $noOfCards : $noOfCardsLeft;
        for ($i = 0; $i < $noOfCardsToGet; ++$i) {
            array_push($cards, $deck->getTopCard());
        }

        foreach ($cards as $card) {
            array_push($cardsImg, $card->getImgUrl());
        }
        $data = [
            'title' => 'Blandad kortlek med bilder, dra ett eller flera kort',
            'noOfCardsLeft' => count($deck->getDeck()),
            'deck' => $cardsImg,
            'drawnCards' => $noOfCardsToGet
        ];

        $session->set('deck', $deck);

        return $this->render('card/drawSeveralImg.html.twig', $data);
    }
}
