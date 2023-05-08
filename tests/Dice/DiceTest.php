<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;

class DiceTest extends TestCase
{
    public function testCreate()
    {
        $die = new Dice();
        $this->assertInstanceOf("\App\Dice\Dice", $die);
        $this->assertNotEmpty($die->getValue());
        $this->assertLessThanOrEqual(6, $die->getValue());
        $this->assertGreaterThanOrEqual(1, $die->getValue());
    }

    public function testValueAsString()
    {
        $die = new Dice();
        $this->assertIsString($die->getAsString());
    }

    public function testRoll()
    {
        $die = new Dice();
        $this->assertLessThanOrEqual(6, $die->getValue());
        $this->assertGreaterThanOrEqual(1, $die->getValue());
        $die->roll();
        $this->assertLessThanOrEqual(6, $die->getValue());
        $this->assertGreaterThanOrEqual(1, $die->getValue());
    }


    /**
     * Construct a mock object of the class Dicec and set consecutive values
     * to assert against.
     */
    public function testCreateObjectWithMock()
    {
        // Create a stub for the SomeClass class.
        $stub = $this->createMock(Dice::class);

        // Configure the stub.
        $stub->method('getValue')
            ->willReturn(6);
        $stub->method('roll')
             ->willReturnOnConsecutiveCalls(2, 3, 5);

        // $stub->doSomething() returns a different value each time
        $this->assertEquals(6, $stub->getValue());
        $this->assertEquals(2, $stub->roll());
        $this->assertEquals(3, $stub->roll());
        $this->assertEquals(5, $stub->roll());
    }
}
