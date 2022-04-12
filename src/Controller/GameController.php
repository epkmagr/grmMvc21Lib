<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function play(SessionInterface $session): Response
    {
        $session->clear();

        return $this->render('game/play.html.twig');
    }
}
