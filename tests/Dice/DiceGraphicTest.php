<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;

class DiceGraphicTest extends TestCase
{
    public function testCreate()
    {
        $die = new DiceGraphic();
        $this->assertInstanceOf("\App\Dice\DiceGraphic", $die);
        $this->assertNotEmpty($die->getValue());
        $this->assertLessThanOrEqual(6, $die->getValue());
        $this->assertGreaterThanOrEqual(1, $die->getValue());
    }

    public function testValueAsString()
    {
        $die = new DiceGraphic();
        $this->assertIsString($die->getAsString());
    }
}
