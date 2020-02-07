<?php

namespace Router\Models;

use PHPUnit\Framework\TestCase;
use Router\src\classes\model\Input;

class InputTest extends TestCase
{

    /**
     * @param $expected
     * @param $jsonString
     * @dataProvider providerJson
     */
    public function testJson($expected, $jsonString)
    {
        $this->assertSame($expected, Input::json($jsonString));
    }
    
    public function providerJson()
    {
        return [
            [null, ''],
            [123456789, '123456789'],
            [[], []],
            [['oleg'], ['oleg']],
            [
                [
                    "name" => "John",
                    "courses" => [ 0 => "html", ],
                    "wife" => null
                ], '{"name": "John","courses": ["html"],"wife": null}'
            ],
            [null, '{"name": John["html"],"wife": null}'],
        ];
    }
}
