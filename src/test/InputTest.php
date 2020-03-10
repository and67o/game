<?php


use PHPUnit\Framework\TestCase;
use Router\Models\Services\Input;

/**
 * Class InputTest
 */
class InputTest extends TestCase
{
    /**
     * @param $expected
     * @param $key
     * @param $data
     * @param $dataType
     * @dataProvider providerGet
     */
    public function testGet($expected, $key, $data, $dataType)
    {
        $observer = $this->getMockBuilder(Input::class)
            ->setMethods(['getData'])
            ->disableOriginalConstructor()
            ->getMock();
    
        $observer->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($data));
        
        /* @var $observer Input */
        $this->assertSame(
            $expected,
            $observer->get($key, $dataType)
        );
    }

    public function providerGet()
    {
        return [
            [0, 0, ['oleg'], 'int'],
            [123, 0, ['123oleg'], 'int'],
            ['oleg', 0, ['oleg'], 'string'],
            [
                [ 0 => "html", ],
                'courses',
                ['courses' => [ 0 => 'html', ],],
                'array'
            ],
            [
                false,
                'wife',
                ['wife' => false],
                'bool'
            ],
            [
                475,
                'oleg',
                ['oleg' => 475],
                'int'
            ],
            ['', 'oleg', [], 'string'],
            ['', false, [], 'string'],
            ['', 0, [], 'string'],
            ['', true, [], 'string'],
            [123, 0, [123], 'int'],
            ['', 0, null, 'string'],
        ];
    }
    
    /**
     * @param $expected
     * @param $jsonString
     * @dataProvider providerJsonParams
     */
    public function testSetParams($expected, $jsonString)
    {
        $observer = $this->getMockBuilder(Input::class)
            ->setMethods(['getData'])
            ->disableOriginalConstructor()
            ->getMock();

        /* @var $observer Input */
        $this->assertSame($expected, $observer->jsonParams($jsonString));
    }

    public function providerJsonParams()
    {
        return [
            [[], false],
            [0, 0],
            [[], null],
            [[], []],
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
            [[], '{"name": John["html"],"wife": null}'],
        ];
    }
}
