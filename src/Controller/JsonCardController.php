<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class JsonCardController extends AbstractController
{
    /**
     * @Route("/card/api/deck", name="deckJson", methods={"GET"})
     */
    public function deckJson(): Response
    {
        $deck = new \App\Card\Deck();

        return $this->createJsonReponse('deck', $deck->getDeck());
    }

    /**
     * @Route("/card/api/deck/shuffle", name="shuffleJson", methods={"GET"})
     */
    public function shuffleJson(SerializerInterface $serializer): Response
    {
        $deck = new \App\Card\Deck();
        $deck->shuffle();

        return $this->createJsonReponse('deck', $deck->getDeck());
    }

    private function createJsonReponse($heading, $content)
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $response = new JsonResponse([$heading => $serializer->serialize($content, 'json')]);
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);

        return $response;
    }
}
