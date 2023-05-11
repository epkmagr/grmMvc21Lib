<?php

namespace App\Card;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Test cases for class Dice.
 */
class CardTest extends KernelTestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
     * Use valid argument.
     */
    public function testCreateObjectWithArgument()
    {
        $card = new Card('♥', '7');
        $this->assertInstanceOf("\App\Card\Card", $card);
        $this->assertEquals($card->getSuit(), '♥');
        $this->assertEquals($card->getValue(), '7');
    }
}
