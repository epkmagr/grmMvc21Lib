<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JsonBookController extends AbstractController
{
    #[Route("/api/library/books", name: "api_book", methods: ["GET","HEAD"])]
    public function showAllBooks(BookRepository $bookRepository): Response
    {
        $books = $bookRepository
            ->findAllSortedByTitle();
        $jsonBooks = array();

        foreach ($books as $book) {
            $info = array();
            $info['title'] = $book->getTitel();
            $info['isbn'] =  $book->getISBN();
            $info['author'] = $book->getAuthor();
            array_push($jsonBooks, $info);
        }
        $data = [
            'books' => $jsonBooks
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
        return $response;
    }

    #[Route("/api/library/books/{isbn}", name: "api_one_book", methods: ["GET"])]
    public function showOneBook(
        BookRepository $bookRepository,
        string $isbn
    ): Response {
        $book = $bookRepository->findOneBy(['isbn' => $isbn]);
        $jsonBooks = array();

        $info = array();
        $info['title'] = $book->getTitel();
        $info['isbn'] =  $book->getISBN();
        $info['author'] = $book->getAuthor();
        array_push($jsonBooks, $info);

        $data = [
            'books' => $jsonBooks
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
        return $response;
    }
}
