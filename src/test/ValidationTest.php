<?php

use PHPUnit\Framework\TestCase;
use Router\Models\Validation;


class ValidationTest extends TestCase
{
	/**
	 * @param $expected
	 * @param $value
	 * @param $name
	 * @dataProvider providerIsValidateEmail
	 */
	public function testIsValidateEmail($expected, $value, $name)
	{
		$Validation = new Validation();
		$this->assertSame(
			$expected, $Validation->setName($name)->setValue($value)->isValidateEmail()->getErrors()
		);
	}

	public function providerIsValidateEmail()
	{
		return [
			[['' => 'Email набран некорректно'], '', null, []],
			[['name' => 'Email набран некорректно'], 'email', 'name'],
			[[], 'email@mail.ru', 'email'],
			[[], 'email@mail', 'email'],
			[[], 'email@mail', ''],
			[['' => 'Email набран некорректно'], 'emailmail.ru', ''],
			[['email' => 'Email набран некорректно'], '\\email@mail', 'email'],
			[['email' => 'Email набран некорректно'], 'emai!@#$%^&*()l@mail', 'email'],
		];
	}
}
