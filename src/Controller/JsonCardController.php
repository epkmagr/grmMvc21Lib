<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $deck = new \App\Card\Deck();

        $response = new JsonResponse(['deck' => $serializer->serialize($deck->getDeck(), 'json')]);
        $response->setEncodingOptions( $response->getEncodingOptions() | JSON_PRETTY_PRINT );

        return $response;

        // return new JsonResponse([
        //     'deck' => $serializer->serialize($deck->getDeck(), 'json')
        // ]);
    }

    /**
     * @Route("/card/api/deck/shuffle", name="shuffleJson", methods={"GET"})
     */
    public function shuffleJson(SerializerInterface $serializer): Response
    {
        $deck = new \App\Card\Deck();
        $deck->shuffle();

        return new JsonResponse([
            'deck' => (object)$deck->getDeck()
        ]);
    }

    // /**
    //  * @Route("/card/deck/reset", name="reset")
    //  */
    // public function reset(RequestStack $requestStack): Response
    // {
    //     $deck = new \App\Card\Deck();
    //     $deck->shuffle();
    //
    //     $noOfCards = count($deck->getDeck());
    //     $number = random_int(0, $noOfCards);
    //     $card = $deck->getCard($number);
    //     $session = $this->requestStack->getSession();
    //     $session->set('deck', $deck);
    //
    //     return $this->render('card/draw.html.twig', [
    //         'card' => $card,
    //         'noOfCardsLeft' => count($deck->getDeck()),
    //     ]);
    // }

    // /**
    //  * @Route("/card/deck/draw", name="draw")
    //  */
    // public function draw(RequestStack $requestStack): Response
    // {
    //     $session = $requestStack->getSession();
    //     $deck = $session->get('deck');
    //     if (!isset($deck)) {
    //         $deck = new \App\Card\Deck();
    //     }
    //     $noOfCards = count($deck->getDeck());
    //     $number = random_int(0, $noOfCards);
    //     $card = $deck->getCard($number);
    //     $session->set('deck', $deck);
    //
    //     return $this->render('card/draw.html.twig', [
    //         'card' => $card,
    //         'noOfCardsLeft' => count($deck->getDeck()),
    //     ]);
    // }
    //
    // /**
    //  * @Route("/card/deck/draw/:{cardNumber}", name="drawNumber")
    //  */
    // public function drawNumber(RequestStack $requestStack, string $cardNumber): Response
    // {
    //     $session = $requestStack->getSession();
    //     $deck = $session->get('deck');
    //     if (!isset($deck)) {
    //         $deck = new \App\Card\Deck();
    //     }
    //     $noOfCards = count($deck->getDeck());
    //     $card = $deck->getCard($cardNumber);
    //     $session->set('deck', $deck);
    //
    //     return $this->render('card/draw.html.twig', [
    //         'card' => $card,
    //         'noOfCardsLeft' => count($deck->getDeck()),
    //     ]);
    // }
    //
    // /**
    //  * @Route("/game/card", name="documentation")
    //  */
    // public function documentation(): Response
    // {
    //     return $this->render('card/documentation.html.twig');
    // }
    //
    // /**
    //  * @Route("/card/deck/deal/:{players}/:{cards}", name="deal")
    //  */
    // public function deal(RequestStack $requestStack, string $players="1", string $cards="1"): Response
    // {
    //     $session = $requestStack->getSession();
    //     $deck = $session->get('deck');
    //     if (!isset($deck)) {
    //         $deck = new \App\Card\Deck();
    //     }
    //     $deck->shuffle();
    //
    //     $bank = $session->get('bank');
    //     if (!isset($bank)) {
    //         $bank = new \App\Card\Player("Banken");
    //     }
    //     $card = $deck->getCard(0);
    //     $bank->increaseHand($card);
    //     $bank->getSumOfHandAceLow();
    //     $session->set('bank', $bank);
    //
    //     $myPlayers = $session->get('myPlayers');
    //     if (!isset($myPlayers)) {
    //         $myPlayers = new \App\Card\Player("Spelare 1");
    //     }
    //
    //     $card = $deck->getCard(0);
    //     $myPlayers->increaseHand($card);
    //     $myPlayers->getSumOfHandAceLow();
    //     $session->set('myPlayers', $myPlayers);
    //     // $myPlayers = $this->createPlayers($players, $cards, $deck);
    //     $noOfCards = count($deck->getDeck());
    //     $session->set('deck', $deck);
    //
    //     return $this->render('card/deal.html.twig', [
    //         'bank' => $bank,
    //         'myPlayers' => $myPlayers,
    //         'noOfCardsLeft' => count($deck->getDeck()),
    //     ]);
    // }
    //
    // /**
    //  * @Route("/card/deck/resetDeal/:{players}/:{cards}", name="resetDeal")
    //  */
    // public function resetDeal(RequestStack $requestStack, string $players="1", string $cards="1"): Response
    // {
    //     $session = $requestStack->getSession();
    //     $deck = new \App\Card\Deck();
    //     $deck->shuffle();
    //
    //     $bank = new \App\Card\Player("Banken");
    //     $card = $deck->getCard(0);
    //     $bank->increaseHand($card);
    //     $bank->getSumOfHandAceLow();
    //     $session->set('bank', $bank);
    //
    //     $myPlayers = new \App\Card\Player("Spelare 1");
    //     $card = $deck->getCard(0);
    //     $myPlayers->increaseHand($card);
    //     $myPlayers->getSumOfHandAceLow();
    //     $session->set('myPlayers', $myPlayers);
    //     // $myPlayers = $this->createPlayers($players, $cards, $deck);
    //     $noOfCards = count($deck->getDeck());
    //     $session->set('deck', $deck);
    //
    //     return $this->render('card/deal.html.twig', [
    //         'bank' => $bank,
    //         'myPlayers' => $myPlayers,
    //         'noOfCardsLeft' => count($deck->getDeck()),
    //     ]);
    // }

    // private function createPlayers(string $players, string $cards = "1", \App\Card\Deck $deck)
    // {
    //     $myPlayers = [];
    //
    //     for ($i = 0; $i < intval($players); $i++) {
    //         $myPlayers[] = new \App\Card\Player("Spelare " . $i);
    //         $myPlayers[] = $myPlayers[$i]->increaseHand($deck);
    //     }
    //
    //     return $myPlayers;
    // }
}
