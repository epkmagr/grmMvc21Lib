<?php

namespace App\Controller;

use App\Card\Game21;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

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
    public function play(Request $request, SessionInterface $session): Response
    {
        $game21 = $session->get('game21') ?? new Game21();

        // Play round
        $resultStr = $game21->play();

        $session->set('game21', $game21);

        return $this->render('game/play.html.twig', [
            'bank' => $game21->getDealer(),
            'myPlayers' => $game21->getPlayers(),
            'noOfCardsLeft' => count($game21->getDeck()),
            'result' => $resultStr,
        ]);
    }

    /**
     * @Route("/game/play", name="gameReset", methods={"POST"})
     */
    public function reset(Request $request, SessionInterface $session): Response
    {
        $clear = $request->request->get('clear');
        if ($clear) {
            $session->clear();
            $deck = new \App\Card\Deck();
            $deck->shuffle();
            $bank = new \App\Card\Player('Banken');
            $myPlayers = [new \App\Card\Player('Spelare 1')];
            $players = '1';
            $cards = '1';

            return $this->redirectToRoute('gamePlay', ['players' => $players, 'cards' => $cards]);
        }
    }
}
