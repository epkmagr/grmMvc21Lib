<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Card\Game21;

class GameController extends AbstractController
{
    /**
     * @Route("/game", name="game", methods={"GET","HEAD"})
     */
    public function start(SessionInterface $session): Response
    {
        $session->clear();

        return $this->render('game/game.html.twig');
    }

    /**
     * @Route("/game/doc", name="documentation")
     */
    public function documentation(): Response
    {
        return $this->render('game/documentation.html.twig');
    }

    /**
     * @Route("/game/play", name="gamePlay", methods={"GET","POST"})
     */
    public function play(SessionInterface $session): Response
    {
        $game21 = $session->get('game21') ?? new Game21();

        // Play round

        $session->set('game21', $game21);
        $resultStr = $game21->result();

        return $this->render('game/play.html.twig', [
            'bank' => $game21->getDealer(),
            'myPlayers' => $game21->getPlayers(),
            'noOfCardsLeft' => count($game21->getDeck()),
            'result' => $resultStr,
        ]);
    }
}
