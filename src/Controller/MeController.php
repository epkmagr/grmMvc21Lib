<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Summary of MeController.
 */
class MeController extends AbstractController
{
    #[Route("/", name: "me")]
    public function start(): Response
    {
        $number = random_int(0, 100);

        return $this->render('me.html.twig', [
            'number' => $number,
        ]);
    }

    #[Route("/metrics", name:"metrics")]
    public function about(): Response
    {
        return $this->render('metrics.html.twig');
    }
}
