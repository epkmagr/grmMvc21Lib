<?php

namespace App\Controller;

use App\Card\Deck;
use App\Card\Game21;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class Game21ImgController extends AbstractController
{
    #[Route("/", name: "home")]
    public function start(): Response
    {
        return $this->render('me.html.twig');
    }

    #[Route("/game/initImg", name: "initImg", methods: ["GET"])]
    public function initImg(SessionInterface $session): Response
    {
        $session->clear();
        $game = new Game21();
        $session->set("spel21Img", $game);

        return $this->render('game21/initImg.html.twig');
    }

    #[Route("/game/initImg", name: "initImgPost", methods: ['POST'])]
    public function initImgCallback(
        Request $request,
        SessionInterface $session
    ): Response {
        $clear = $request->request->get('clear');
        if ($clear) {
            return $this->redirectToRoute('initImg');
        }
        $noOfPlayers = intval($request->request->get('noOfPlayers'));
        $noOfCards = intval($request->request->get('noOfCards'));
        $game = $session->get("spel21Img");
        $game->initGame($noOfPlayers, $noOfCards);
        $session->set("spel21Img", $game);

        return $this->redirectToRoute('dealImgPost');
    }

    #[Route("/game/dealImg", name: "dealImg", methods: ["GET"])]
    public function dealImg(SessionInterface $session): Response
    {
        $game = $session->get("spel21Img");

        $data = [
            'title' => 'Spela 21, kortlek med bilder',
            'bank' => $game->getDealer(),
            'myPlayers' => $game->getPlayers(),
            'noOfCardsLeft' => $game->getDeck()->getNoOfCards(),
            'result' => $game->getWinner(),
        ];

        return $this->render('game21/dealImg.html.twig', $data);
    }

    #[Route("/game/dealImg", name: "dealImgPost", methods: ['POST'])]
    public function dealImgCallback(Request $request, SessionInterface $session): Response
    {
        $game = $session->get("spel21Img");

        (!$game->isItGameover() && $request->request->get('deal')) ? $game->play() : $game->result();

        $session->set("spel21Img", $game);

        return $this->redirectToRoute('dealImg');
    }

    #[Route("/game/contentImg", name: "setContent", methods: ['POST'])]
    public function setContentCallback(Request $request, SessionInterface $session): Response
    {
        $game = $session->get("spel21Img");

        foreach ($game->getPlayers() as $i => $player) {
            $name = 'content' . $i;
            $content = $request->request->get($name);
            if ($content) {
                $player->setContent();
            }
        }

        $session->set("spel21Img", $game);

        return $this->redirectToRoute('dealImg');
    }
}
