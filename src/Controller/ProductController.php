<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(SessionInterface $session): Response
    {
        $noOfProducts = $session->get('no_of_products') ?? 0;
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'no_of_products' => $noOfProducts
        ]);
    }

    #[Route('/product/create', name: 'create_product')]
    public function createProduct(
        ManagerRegistry $doctrine,
        SessionInterface $session
    ): Response {
        $entityManager = $doctrine->getManager();

        $product = new Product();
        $product->setName('Keyboard_num_' . rand(1, 9));
        $product->setValue(rand(100, 999));

        $noOfProducts = $session->get('no_of_products') ?? 0;
        $session->set('no_of_products', intval($noOfProducts) + 1);

        // tell Doctrine you want to (eventually) save the Product
        // (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());
    }

    #[Route('/product/show', name: 'product_show_all')]
    public function showAllProduct(
        ProductRepository $productRepository
    ): Response {
        $products = $productRepository
            ->findAll();

        return $this->json($products);
    }

    #[Route('/product/show/{id}', name: 'product_by_id')]
    public function showProductById(
        ProductRepository $productRepository,
        int $id
    ): Response {
        $product = $productRepository
            ->find($id);

        return $this->json($product);
    }

    #[Route('/product/delete/{id}', name: 'product_delete_by_id')]
    public function deleteProductById(
        ManagerRegistry $doctrine,
        SessionInterface $session,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $noOfProducts = $session->get('no_of_products') ?? 0;
        $session->set('no_of_products', intval($noOfProducts) - 1);

        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('product_show_all');
    }

    #[Route('/product/update/{id}/{value}', name: 'product_update')]
    public function updateProduct(
        ManagerRegistry $doctrine,
        int $id,
        int $value
    ): Response {
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $product->setValue($value);
        $entityManager->flush();

        return $this->redirectToRoute('product_show_all');
    }

    #[Route("/product/reset", name: "productReset", methods: ["GET"])]
    public function productReset(SessionInterface $session): Response
    {
        $session->clear();

        return $this->redirectToRoute('app_product');
    }
}
