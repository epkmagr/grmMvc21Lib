<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Book;
use App\Repository\BookRepository;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        // echo $_ENV['APP_ENV'];
        // echo $_ENV['DATABASE_URL'];
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route("/book/create", name: "create_book")]
    public function createbook(ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
        $doSave = $request->request->get('doSave');

        if ($doSave) {
            $book = new book();
            $bookTitle = $request->request->get('bookTitle');
            $bookISBN = $request->request->get('bookISBN');
            $bookAuthor = $request->request->get('bookAuthor');
            $book->setTitel($bookTitle);
            $book->setISBN($bookISBN);
            $book->setAuthor($bookAuthor);

            // tell Doctrine you want to (eventually) save the book (no queries yet)
            $entityManager->persist($book);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
        }

        return $this->render('book/create.html.twig', [
            'book' => $book ?? null,
        ]);
    }

    /**
     * @Route("/book/show", name="show_all_books")
    */
    public function showAllBooks(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository
            ->findAllSortedByTitle();

        return $this->render('book/showAll.html.twig', [
            'books' => $books ?? null,
        ]);
    }

    /**
     * @Route("/book/show/{id}", name="show_book")
     */
    public function showBookById(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository
            ->find($id);

        return $this->render('book/showOne.html.twig', [
            'book' => $book ?? null,
            'id' => $id,
        ]);
    }

    /**
     * @Route("/book/delete/{id}", name="delete_book", methods={"GET","POST"})
     */
    public function deleteBookById(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id ' . $id
            );
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('show_all_books');
    }

    /**
     * @Route("/book/update/{id}", name="update_book", methods={"GET","POST"})
     */
    public function updateBook(
        ManagerRegistry $doctrine,
        Request $request,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);
        $doUpdate = $request->request->get('doUpdate');

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id ' . $id
            );
        }

        if ($doUpdate) {
            $bookTitle = $request->request->get('bookTitle');
            $bookISBN = $request->request->get('bookISBN');
            $bookAuthor = $request->request->get('bookAuthor');
            $book->setTitel($bookTitle);
            $book->setISBN($bookISBN);
            $book->setAuthor($bookAuthor);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
        }

        return $this->render('book/update.html.twig', [
            'book' => $book ?? null,
        ]);
    }
}
