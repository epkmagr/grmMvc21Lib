<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Services;
use App\Repository\ServicesRepository;

class GardenController extends AbstractController
{
    #[Route('/proj', name: 'app_garden')]
    public function index(): Response
    {
        return $this->render('garden/index.html.twig', [
            'controller_name' => 'GardenController',
        ]);
    }

    #[Route('/proj/about', name: 'about_garden')]
    public function about(): Response
    {
        return $this->render('garden/about.html.twig');
    }

    #[Route('/proj/services', name: 'services_garden')]
    public function services(): Response
    {
        return $this->render('garden/services.html.twig');
    }

    /**
     * @Route("/proj/services/show", name="show_all_services_garden")
    */
    public function showAllServices(
        servicesRepository $servicesRepository
    ): Response {
        $services = $servicesRepository
            ->findAll();

        return $this->render('garden/services/showAll.html.twig', [
            'services' => $services ?? null,
        ]);
    }

    #[Route('/proj/blogg', name: 'blogg_garden')]
    public function blogg(): Response
    {
        return $this->render('garden/blogg.html.twig');
    }

    #[Route("/proj/services/create", name: "create_services_garden")]
    public function creategarden(ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
        $doCreate = $request->request->get('doCreate');

        if ($doCreate) {
            $services = new services();
            $serviceTitle = $request->request->get('serviceTitle');
            $serviceImage = $request->request->get('serviceImage');
            $servicePrice = $request->request->get('servicePrice');
            $services->setTitle($serviceTitle);
            $services->setISBN($serviceImage);
            $services->setAuthor($servicePrice);

            // tell Doctrine you want to (eventually) save the garden (no queries yet)
            $entityManager->persist($services);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
        }

        return $this->render('garden/services/create.html.twig', [
            'services' => $services ?? null,
        ]);
    }

    /**
     * @Route("/garden/show/{id}", name="show_garden")
     */
    public function showgardenById(
        gardenRepository $gardenRepository,
        int $id
    ): Response {
        $garden = $gardenRepository
            ->find($id);

        return $this->render('garden/showOne.html.twig', [
            'garden' => $garden ?? null,
            'id' => $id,
        ]);
    }

    /**
     * @Route("/garden/delete/{id}", name="delete_garden", methods={"GET","POST"})
     */
    public function deletegardenById(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $garden = $entityManager->getRepository(garden::class)->find($id);

        if (!$garden) {
            throw $this->createNotFoundException(
                'No garden found for id ' . $id
            );
        }

        $entityManager->remove($garden);
        $entityManager->flush();

        return $this->redirectToRoute('show_all_gardens');
    }

    /**
     * @Route("/garden/update/{id}", name="update_garden", methods={"GET","POST"})
     */
    public function updategarden(
        ManagerRegistry $doctrine,
        Request $request,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $garden = $entityManager->getRepository(garden::class)->find($id);
        $doUpdate = $request->request->get('doUpdate');

        if (!$garden) {
            throw $this->createNotFoundException(
                'No garden found for id ' . $id
            );
        }

        if ($doUpdate) {
            $gardenTitle = $request->request->get('gardenTitle');
            $gardenISBN = $request->request->get('gardenISBN');
            $gardenAuthor = $request->request->get('gardenAuthor');
            $garden->setTitel($gardenTitle);
            $garden->setISBN($gardenISBN);
            $garden->setAuthor($gardenAuthor);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
        }

        return $this->render('garden/update.html.twig', [
            'garden' => $garden ?? null,
        ]);
    }
}
