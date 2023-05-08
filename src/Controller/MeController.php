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

    #[Route("/about", name:"about")]
    public function about(): Response
    {
        $kmom = '0';

        return $this->render('me_about.html.twig', [
            'kmom' => $kmom,
        ]);
    }

    #[Route("/report/{showKmom}", name:"report")]
    public function report(string $showKmom = '0'): Response
    {
        $kmom = '0' !== $showKmom ? $showKmom : '0';

        return $this->render('me_report.html.twig', [
            'kmom' => $kmom,
        ]);
    }

    #[Route("/report#{showKmom2}", name:"report2")]
    public function report2(string $showKmom2 = '0'): Response
    {
        $kmom = '0' !== $showKmom2 ? $showKmom2 : '0';

        return $this->render('me_report.html.twig', [
            'kmom' => $kmom,
        ]);
    }

    #[Route("/exercises", name:"exercises")]
    public function exercises(): Response
    {
        return $this->render('exercises/exercises.html.twig', [
        ]);
    }

    #[Route("/kmom01", name: "kmom01")]
    public function kmom01(): Response
    {
        return $this->render('kmom01.html.twig');
    }

    #[Route("/lucky", name: "lucky")]
    public function lucky(): Response
    {
        $number = random_int(0, 100);

        $data = [
            'number' => $number
        ];

        return $this->render('kmom01/lucky.html.twig', $data);
    }

    #[Route("/api/quote", name: "quote")]
    public function quote(): Response
    {
        $quotes = [ "Säg JA till livet, och se hur livet plötsligt börjar arbeta för dig istället för emot dig.",
            "Sjömannen ber inte om medvind, han lär sig segla.",
            "Antingen så hittar jag en väg, eller så skapar jag en.",
            "Du är tillräcklig som du är. Du har inget att bevisa för någon."
        ];
        date_default_timezone_set('Europe/Stockholm');

        $number = random_int(0, 3);

        //$quotes = array("quote1", "quote2", "quote3", "quote4");
        //$random_index = array_rand($quotes);
        //$random_quote = $quotes[$random_index];

        $data = [
            'quote' => $quotes[(int)$number], //$random_quote
            'date' => date("d-m-y h:i:s")
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
        return $response;
    }

    public function __construct()
    {
    }
}
