<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Book;
use App\Repository\BookRepository;

/**
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book', methods: ["GET","HEAD"])]
    public function index(): Response
    {
        // echo $_ENV['APP_ENV'];
        // echo $_ENV['DATABASE_URL'];
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route("/book/create", name: "create_book", methods: ["GET"])]
    public function createbook(
        SessionInterface $session
    ): Response {
        return $this->render('book/create.html.twig', [
            'book' => $session->get('createdBook') ?? null,
        ]);
    }

    #[Route("/book/create", name: "save_book", methods: ["POST"])]
    public function savebook(
        BookRepository $bookRepository,
        Request $request,
        SessionInterface $session
    ): Response {
        $book = new book();
        $bookTitle = $request->request->get('bookTitle');
        $bookISBN = $request->request->get('bookISBN');
        $bookAuthor = $request->request->get('bookAuthor');
        $book->setTitel($bookTitle);
        $book->setISBN($bookISBN);
        $book->setAuthor($bookAuthor);
        $session->set('createdBook', $book);

        $bookRepository->add($book);

        return $this->redirectToRoute('create_book');
    }

    #[Route('/book/show', name: 'show_all_books', methods: ["GET"])]
    public function showAllBooks(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository
            ->findAllSortedByTitle();

        return $this->render('book/showAll.html.twig', [
            'books' => $books ?? null,
        ]);
    }

    #[Route('/book/show/{id}', name: 'show_book', methods: ["GET"])]
    public function showBookById(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository->find($id);

        return $this->render('book/showOne.html.twig', [
            'book' => $book ?? null,
            'id' => $id,
        ]);
    }

    #[Route("/book/delete/{id}", name: "delete_book", methods: ["GET"])]
    public function deleteBookById(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository->find($id);

        return $this->render('book/deleteOne.html.twig', [
            'book' => $book ?? null,
            'id' => $id,
        ]);
    }

    #[Route("/book/delete/{id}", name: "do_delete_book", methods: ["POST"])]
    public function doDeleteBookById(
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

    #[Route("/book/update/{id}", name: "update_book", methods: ["GET"])]
    public function updateBook(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id ' . $id
            );
        }

        return $this->render('book/update.html.twig', [
            'book' => $book
        ]);
    }

    #[Route("/book/update/{id}", name: "do_update_book", methods: ["POST"])]
    public function doUpdateBook(
        BookRepository $bookRepository,
        Request $request,
        int $id
    ): Response {
        $book = $bookRepository->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id ' . $id
            );
        }

        $bookTitle = $request->request->get('bookTitle');
        $bookISBN = $request->request->get('bookISBN');
        $bookAuthor = $request->request->get('bookAuthor');
        $book->setTitel($bookTitle);
        $book->setISBN($bookISBN);
        $book->setAuthor($bookAuthor);

        $bookRepository->save($book);

        return $this->redirectToRoute('update_book', ['id'=> $id]);
    }
}
