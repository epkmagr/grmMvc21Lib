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
    #[Route("/api/game", name: "gameStatus", methods: ["GET"])]
    public function gameStatus(SessionInterface $session): Response
    {
        $game = $session->get('spel21Img');
        $data = $game->prepareJsonDeal();
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
        return $response;
    }
}
