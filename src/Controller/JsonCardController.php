<?php

namespace App\Controller;

use App\Card\Deck;
use App\Card\Game21;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class JsonCardController extends AbstractController
{
    #[Route("/api", name: "apiHome", methods: ["GET","HEAD"])]
    public function apiHome(SessionInterface $session): Response
    {
        $session->clear();
        $deck = new Deck();
        $session->set("deck", $deck);

        return $this->render('api/home.html.twig');
    }

    #[Route("/api/deck", name: "deckJson", methods: ["GET"])]
    public function deckJson(SessionInterface $session): Response
    {
        $deck = $session->get("deck");
        $assDeck = array();

        foreach ($deck->getDeck() as $card) {
            array_push($assDeck, $card->getSuit() . $card->getValue());
        }

        $data = [
            'deck' => $assDeck
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
        return $response;
    }

    #[Route("/api/deck/shuffle", name: "shuffleJson", methods: ["POST"])]
    public function shuffleJson(SessionInterface $session): Response
    {
        $deck = $session->get("deck");
        $assDeck = array();

        $deck->shuffle();
        foreach ($deck->getDeck() as $card) {
            array_push($assDeck, $card->getSuit() . $card->getValue());
        }

        $data = [
            'deck' => $assDeck
        ];

        $session->set("deck", $deck);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
        return $response;
    }

    #[Route("/api/deck/draw", name: "drawJson", methods: ["POST"])]
    public function drawJson(SessionInterface $session): Response
    {
        $this->prepareJsonData($session);
        $session->set("jsonDataPost", 1);

        return $this->redirectToRoute('drawJsonShow');
    }

    #[Route("/api/deck/draw", name: "drawJsonShow", methods: ["GET"])]
    public function drawJsonShow(SessionInterface $session): Response
    {
        $newJsonData = $session->get('jsonDataPost');
        if ($newJsonData !== 1) {
            $this->prepareJsonData($session);
        }
        $session->set("jsonDataPost", 0);
        $data = $session->get('jsonData');

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
        return $response;
    }

    #[Route("/api/deck/drawSeveral", name: "drawSeveralJson", methods: ["POST"])]
    public function drawSeveralJson(Request $request, SessionInterface $session): Response
    {
        $session->set("noOfCards", intval($request->request->get('number')));
        $this->prepareJsonData($session);
        $session->set("jsonDataPost", 1);

        return $this->redirectToRoute('drawSeveralJsonShow');
    }

    #[Route("/api/deck/drawSeveral", name: "drawSeveralJsonShow", methods: ["GET"])]
    public function drawSeveralJsonShow(SessionInterface $session): Response
    {
        $newJsonData = $session->get('jsonDataPost');
        if ($newJsonData !== 1) {
            $this->prepareJsonData($session);
        }
        $session->set("jsonDataPost", 0);
        $data = $session->get('jsonData');

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
        return $response;
    }

    #[Route("/api/game", name: "dealJson", methods: ["POST"])]
    public function dealJson(Request $request, SessionInterface $session): Response
    {
        $game = new Game21();
        $noOfPlayers = intval($request->request->get('player'));
        $noOfCards = intval($request->request->get('number'));
        $game->initGame($noOfPlayers, $noOfCards);

        $session->set("spel21", $game);

        return $this->redirectToRoute('dealJsonShow');
    }

    #[Route("/api/game", name: "dealJsonShow", methods: ["GET"])]
    public function dealJsonShow(SessionInterface $session): Response
    {
        $this->prepareJsonDeal($session);
        $data = $session->get('jsonData');
        //$this->prepareJsonDeal($session);
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
        return $response;
    }

    private function prepareJsonData(SessionInterface $session)
    {
        $cards = array();

        $deck = $session->get("deck");
        $noOfCards = $session->get("noOfCards") ?? 1;
        $noOfCardsLeft = count($deck->getDeck());
        $noOfCardsToGet = ($noOfCardsLeft >= $noOfCards) ? $noOfCards : $noOfCardsLeft;
        for ($i = 0; $i < $noOfCardsToGet; ++$i) {
            $card = $deck->getTopCard();
            array_push($cards, $card->getSuit() . $card->getValue());
        }
        $session->set("deck", $deck);

        $data = [
            'no of cards to draw' => $noOfCards,
            'card' => $cards,
            'remaining cards' => count($deck->getDeck())
        ];
        $session->set("jsonData", $data);
    }

    private function prepareJsonDeal(SessionInterface $session)
    {
        $game = $session->get("spel21");

        (!$game->isItGameover()) ? $game->play() : $game->result();
        foreach ($game->getPlayers() as $player) {
            $player->getResult();
            if ($player->getBestScore() > 17) {
                $player->setContent();
            }
        }
        $allPlayersInfo = $game->getAllPlayersInfo(true);
        $session->set("spel21", $game);

        $data = [
            'no of players' => $game->getNoOfPlayers(),
            'no of cards to draw' => $game->getNoOfCards(),
            'Players info' => $allPlayersInfo,
            'remaining cards' => $game->getDeck()->getNoOfCards(),
            'the winner is' => $game->getWinner()
        ];
        $session->set("jsonData", $data);
    }
}
