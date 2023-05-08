<?php

namespace App\Dice;

class Dice
{
    protected int $value;

    public function __construct(int $value=0)
    {
        $this->value = random_int(1, 6);
        if ($value !== 0) {
            $this->value = $value;
        }
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function roll(): int
    {
        $this->value = random_int(1, 6);

        return $this->value;
    }

    public function getAsString(): string
    {
        return "[{$this->value}]";
    }
}
