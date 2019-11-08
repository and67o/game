<?php

use PHPUnit\Framework\TestCase;
use Router\src\classes\model\Validation;


class ValidationTest extends TestCase
{
	/**
	 * @param $expected
	 * @param $value
	 * @param $name
	 * @dataProvider minIsValidateEmail
	 */
	public function testIsValidateEmail($expected, $value, $name)
	{
		$Validation = new Validation();
		$this->assertSame(
			$expected, $Validation->setName($name)->setValue($value)->isValidateEmail()->getErrors()
		);
	}

	public function minIsValidateEmail()
	{
		return [
			[['' => 'Email набран некорректно'], '', null, []],
			[['name' => 'Email набран некорректно'], 'email', 'name'],
			[null, 'email@mail.ru', 'email'],
			[null, 'email@mail', 'email'],
			[null, 'email@mail', ''],
			[['' => 'Email набран некорректно'], 'emailmail.ru', ''],
			[['email' => 'Email набран некорректно'], '\\email@mail', 'email'],
			[['email' => 'Email набран некорректно'], 'emai!@#$%^&*()l@mail', 'email'],
		];
	}
}
