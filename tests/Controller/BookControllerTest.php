<?php

namespace App\Controller;

/* use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test class for MainController
 */
/* 
class BookControllerTest extends WebTestCase
{
    public function testBookApp(): void
    {
        $client = static::createClient();
        $client->request('GET', '/book');
        $this->assertResponseIsSuccessful();
        $this->assertRouteSame('app_book');
        $this->assertSelectorTextContains('h1', 'Bibliotek');
        $this->assertSelectorTextContains('h3', 'Välkommen till biblioteket!');
    }

    public function testShowAllBooks(): void
    {
        $client = static::createClient();
        $client->request('GET', '/book/show');
        $this->assertResponseIsSuccessful();
        $this->assertRouteSame('show_all_books');
        $this->assertSelectorTextContains('h1', 'Bibliotek');
        $this->assertSelectorTextContains('h3', 'Lista på alla böcker');
        // $this->assertSelectorTextContains('th', 'Titel');
        // $this->assertSelectorTextContains('th', 'Författare');
    }

     public function testCreateBook(): void
     {
         $client = static::createClient();
         $client->request('GET', '/book/create');
         $this->assertResponseIsSuccessful();
         $this->assertRouteSame('create_book');
         $this->assertSelectorTextContains('h1', 'Bibliotek');
         $this->assertSelectorTextContains('legend', 'Lägg till en ny book');
     }

   public function testSaveBook(): void
     {
         $client = static::createClient();
         $client->request('POST', '/book/create');
         $this->assertResponseIsSuccessful();
         $this->assertRouteSame('save_book');
         $this->assertSelectorTextContains('h1', 'New deck');
     }
}
 */