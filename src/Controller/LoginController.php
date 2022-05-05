<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;

class LoginController extends AbstractController
{
    /**
     * @Route(
     *      "/admin/login",
     *      name="login",
     *      methods={"GET","HEAD"}
     * )
     */
    public function login(): Response
    {
        return $this->render('admin/login.html.twig');
    }

    /**
     * @Route(
     *      "/admin/login",
     *      name="login-process",
     *      methods={"POST"}
     * )
     */
    public function loginProcess(ManagerRegistry $doctrine, Request $request): Response
    {
        $doLogin = $request->request->get('doLogin');
        $doCreate = $request->request->get('doCreate');

        if ($doCreate) {
            return $this->render('admin/create.html.twig');
        }

        if ($doLogin) {
            $user = $request->request->get('user');
            $pwd  = $request->request->get('pwd');
            $found = $doctrine->getRepository(User::class)->findUser($user);
            $type = "notice";
            $isEqual = "NOT";
            if ($pwd === $found->getPassword()) {
                $type = "warning";
                $isEqual = "";
            }

            $this->addFlash($type, "The username and password did $isEqual match.");
        }

        return $this->redirectToRoute('login');
    }

    /**
     * @Route(
     *      "/admin/createUser",
     *      name="createUser",
     *      methods={"GET","HEAD"}
     * )
     */
    public function createUser(): Response
    {
        return $this->render('admin/create.html.twig');
    }

    /**
     * @Route(
     *      "/admin/createUser",
     *      name="createUser-process",
     *      methods={"POST"}
     * )
     */
    public function createUserProcess(ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
        $doCreate = $request->request->get('doCreate');
        $userAcronym = "";

        if ($doCreate) {
            $user = new user();
            $userEmail = $request->request->get('userEmail');
            $userAcronym = $request->request->get('userAcronym');
            $userName = $request->request->get('userName');
            $userPassword = $request->request->get('userPassword');
            $isAdmin = $request->request->get('isAdmin');
            $user->setEmail($userEmail);
            $user->setAcronym($userAcronym);
            $user->setName($userName);
            $user->setPassword($userPassword);
            $user->setIsAdmin(false);
            if ($isAdmin) {
                $user->setIsAdmin(true);
            }

            // tell Doctrine you want to (eventually) save the user (no queries yet)
            $entityManager->persist($user);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
        }

        $this->addFlash("notice", "The username with acronym $userAcronym is created.");

        return $this->redirectToRoute('login');
    }
}
