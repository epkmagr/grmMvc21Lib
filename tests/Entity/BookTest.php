<?php

namespace App\Entity;

use phpDocumentor\Reflection\Types\Integer;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Entity class Book.
 */
class BookTest extends TestCase
{
    /**
     * Create an empty Book object and validate its state
     */
    public function testCreateEmptyBook()
    {
        $book = new Book();
        $this->assertInstanceOf("\App\Entity\Book", $book);
        $this->assertNull($book->getId());
        $this->assertEquals("", $book->getTitel());
        $this->assertEquals("", $book->getISBN());
        $this->assertEquals("", $book->getAuthor());
        $this->assertNull($book->getImage());
    }

    /**
     * Create an empty Book object, set its state and validate it
     */
    public function testCreateBook()
    {
        $book = new Book();
        $book->setTitel("Hej");
        $book->setISBN("777");
        $book->setAuthor("John Doe");
        $book->setImage("doe.jpg");
        $this->assertInstanceOf("\App\Entity\Book", $book);
        $this->assertNull($book->getId());
        $this->assertEquals("Hej", $book->getTitel());
        $this->assertEquals("777", $book->getISBN());
        $this->assertEquals("John Doe", $book->getAuthor());
        $this->assertEquals("doe.jpg", $book->getImage());
    }
}
