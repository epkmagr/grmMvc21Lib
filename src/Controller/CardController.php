<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    /**
     * @Route("/card", name="card")
     */
    public function card(): Response
    {
        return $this->render('card/card.html.twig');
    }

    /**
     * @Route("/card/play", name="cardPlay")
     */
    public function play(): Response
    {
        $kmom = "0";

        return $this->render('me_about.html.twig', [
            'kmom' => $kmom,
        ]);
    }
}
