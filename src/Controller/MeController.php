<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MeController extends AbstractController
{
    /**
     * @Route("/me", name="me")
     */
    public function start(): Response
    {
        $number = random_int(0, 100);

        return $this->render('me.html.twig', [
            'number' => $number,
        ]);
    }

    /**
     * @Route("/me/about", name="about")
     */
    public function about(): Response
    {
        $kmom = "0";

        return $this->render('me_about.html.twig', [
            'kmom' => $kmom,
        ]);
    }

    /**
     * @Route("/me/report/{show_kmom}", name="report")
     */
    public function report(string $show_kmom="0"): Response
    {
        $kmom = $show_kmom !== "0" ? $show_kmom : "0";

        return $this->render('me_report.html.twig', [
            'kmom' => $kmom,
        ]);
    }
}
