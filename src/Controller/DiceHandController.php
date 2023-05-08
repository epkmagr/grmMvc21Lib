<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Dice\Dice;
use App\Dice\DiceHand;
use App\Dice\DiceGraphic;

class DiceHandController extends AbstractController
{
    /**
     * @Route(
     *      "/dice/hand",
     *      name="dice-hand-home",
     *      methods={"GET","HEAD"}
     * )
     */
    public function home(): Response
    {
        return $this->render('dice/hand.html.twig');
    }

    /**
     * @Route(
     *      "/dice/hand",
     *      name="dice-hand-process",
     *      methods={"POST"}
     * )
     */
    public function process(
        Request $request,
        SessionInterface $session
    ): Response {
        /**
         * @var array<int, Dice>
         */
        $hand = $session->get('dicehand') ?? new DiceHand();

        $roll = $request->request->get('roll');
        $add = $request->request->get('add');
        $clear = $request->request->get('clear');

        if ($roll) {
            $hand->roll();
        } elseif ($add) {
            $hand->add(new Dice());
        //$hand->add(new DiceGraphic());
        } elseif ($clear) {
            $hand = new DiceHand();
        }

        $session->set('dicehand', $hand);

        $this->addFlash('info', 'Din tärningshand har ' . $hand->getNumberDices() . ' tärningar.');
        $this->addFlash('info', 'Valörer: ' . $hand->getAsString());

        return $this->redirectToRoute('dice-hand-home');
    }
}
