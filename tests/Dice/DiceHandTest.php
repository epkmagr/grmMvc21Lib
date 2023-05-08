<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;

class DiceHandTest extends TestCase
{
    public function testCreate()
    {
        $dieHand = new DiceHand();
        $this->assertInstanceOf("\App\Dice\DiceHand", $dieHand);
        $this->assertEquals(0, $dieHand->getNumberDices());
        $this->assertEquals([], $dieHand->getValues());
        $this->assertEquals([], $dieHand->getString());
        $this->assertEquals(0, $dieHand->getSum());
    }

    public function testAdd3Dice()
    {
        $dieHand = new DiceHand();
        $die1 = new Dice(2);
        $die2 = new Dice(3);
        $die3 = new Dice(6);
        $dieHand->add($die1);
        $dieHand->add($die2);
        $dieHand->add($die3);
        $this->assertEquals(3, $dieHand->getNumberDices());
        $this->assertEquals([2, 3, 6], $dieHand->getValues());
        $this->assertEquals(["[2]", "[3]", "[6]"], $dieHand->getString());
        $this->assertEquals(11, $dieHand->getSum());
    }

    public function testRoll()
    {
        $dieHand = new DiceHand();
        $die1 = new Dice(2);
        $die2 = new Dice(3);
        $die3 = new Dice(6);
        $dieHand->add($die1);
        $dieHand->add($die2);
        $dieHand->add($die3);
        $dieHand->roll();
        $this->assertEquals(3, $dieHand->getNumberDices());
        $this->assertNotEquals([2, 3, 6], $dieHand->getValues());
        $this->assertIsInt(11, $dieHand->getSum());
    }
}
