<?php

use Router\Models\Services\SqlHelper;
use PHPUnit\Framework\TestCase;


class SqlHelperTest extends TestCase
{
    /**
     * @param $expected
     * @param $values
     * @dataProvider providerSqlArrayToIn
     */
    public function testSqlArrayToIn($expected, $values)
    {
        $this->assertSame($expected, SqlHelper::sqlArrayToIn($values));
    }
    
    public function providerSqlArrayToIn()
    {
        return [
            ['"1", "2", "3", "4"', [1, 2, 3, 4]],
            ['"one", "2", "three", "4"', ['one', 2, 'three', 4]],
            ['"", "oleg", "", "15522"', [false, 'oleg', null, 15522]],
            ['""', ['']],
            ['"0"', ['0']],
            ['""', 0],
            ['""', ''],
            [
                '"1", "2", "3", "4", "5", "6", "7", "5343", "3445", "465", "676", "7", ' .
                '"78", "4", "3", "36", "7643", "2", "354", "67", "7799", "9"',
                [1, 2, 3, 4, 5, 6, 7, 5343, 3445, 465, 676, 7, 78, 4, 3, 36, 7643, 2, 354, 67, 7799, 9]
            ],
        
        ];
    }
}
