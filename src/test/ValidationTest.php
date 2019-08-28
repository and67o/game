<?php
require_once '../classes/model/Validation.php';

use PHPUnit\Framework\TestCase;
use Router\src\classes\model\Validation;


class ValidationTest extends TestCase
{
	/**
	 * @param $expected
	 * @param $string
	 * @param $minLength
	 * @param $hardCheck
	 * @dataProvider minLengthProvider
	 */
	public function testMinLength($expected, $string, $minLength, $hardCheck)
	{
		$this->assertSame($expected, Validation::minLength($string, $minLength, $hardCheck));
	}
	
	public function minLengthProvider()
	{
		return [
			[false, null, null, null],
			[false, 'check', 3, false],
			[false, 'check', 5, true],
			[true, 'check', 6, false],
			[false, '', 0, false],
			[false, '', 0, true],
		];
	}
}
