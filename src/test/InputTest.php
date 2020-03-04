<?php


use PHPUnit\Framework\TestCase;
use Router\Models\Services\Input;

class InputTest extends TestCase
{
    /**
     * @param $expected
     * @param $key
     * @param $data
     * @dataProvider providerGet
     */
    public function testGet($expected, $key, $data)
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
            $observer->get($key)
        );
    }

    public function providerGet()
    {
        return [
            ['oleg', 0, ['oleg']],
            [
                [ 0 => "html", ],
                'courses',
                ['courses' => [ 0 => 'html', ],]
            ],
            [
                false,
                'wife',
                ['wife' => false]
            ],
            [
                475,
                'oleg',
                ['oleg' => 475]
            ],
            ['', 'oleg', []],
            ['', false, []],
            ['', 0, []],
            ['', true, []],
            [123, 0, [123]],
            ['', 0, null],
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

        $observer->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($jsonString));

        /* @var $observer Input */
        $this->assertSame($expected, $observer->jsonParams());
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
