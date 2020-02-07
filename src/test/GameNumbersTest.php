<?php

namespace Router\Models;

use Router\src\classes\model\GameNumbers;
use PHPUnit\Framework\TestCase;


class GameNumbersTest extends TestCase
{

    public function testCreateNumber()
    {
        $newNumber = GameNumbers::createNumber();
        $this->assertTrue(
            count(
                array_unique(
                    str_split($newNumber)
                )
            ) === 4
        );
    }
}
