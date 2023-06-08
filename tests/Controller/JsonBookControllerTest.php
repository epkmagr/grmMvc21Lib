<?php

namespace App\Controller;

/* use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JsonLibraryControllerTest extends WebTestCase
{
    public function testShowAllBooks(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/library/books');
        $this->assertResponseIsSuccessful();
        $this->assertRouteSame('api_book');
    }

        public function testShowABookByIsbn(): void
        {
            $client = static::createClient();
            $client->request('GET', '/api/library/books/4444');
            $this->assertResponseIsSuccessful();
            $this->assertRouteSame('api_one_book');
            $response = strval($client->getResponse()->getContent());
            $this->assertJson($response);
            $this->assertStringContainsString("Sara Grahn", $response);
        }
}
 */