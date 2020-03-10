<?php

use PHPUnit\Framework\TestCase;
use Router\Models\Validation;

/**
 * Class ValidationTest
 */
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
			$expected, $Validation
                ->setName($name)
                ->setValue($value)
                ->isValidateEmail()
                ->getErrors()
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

    /**
     * @param $expected
     * @param $value
     * @param $name
     * @dataProvider providerRequired
     */
	public function testRequired($expected, $value, $name) {
        $Validation = new Validation();
        $this->assertSame(
            $expected, $Validation
                ->setName($name)
                ->setValue($value)
                ->required()
                ->getErrors()
        );
    }
    
    public function providerRequired()
    {
        return [
            [['' => 'Поле  Пустое'], '', ''],
            [[], 'oleg', ''],
            [['oleg' => 'Поле oleg Пустое'], '', 'oleg'],
            [[], 'oleg', 'oleg'],
        ];
    }
    
    /**
     * @param $expected
     * @param $value
     * @param $minLength
     * @dataProvider providerMin
     */
    public function testMin($expected, $value, $minLength) {
        $Validation = new Validation();
        $this->assertSame(
            $expected, $Validation
            ->setValue($value)
            ->min($minLength)
            ->getErrors()
        );
    }
    
    public function providerMin()
    {
        return [
            [['' => 'У поля маловато символов'], '', 3],
            [['' => 'У поля маловато символов'], '12', 3],
            [[], '123', 3],
            [['' => 'У поля маловато символов'], '123', 61],
            [[], 123, 61],
            [['' => 'У поля маловато цифр'], 61, 123],
        ];
    }
    
    /**
     * @param $expected
     * @param $value
     * @param $maxLength
     * @dataProvider providerMax
     */
    public function testMax($expected, $value, $maxLength) {
        $Validation = new Validation();
        $this->assertSame(
            $expected, $Validation
            ->setValue($value)
            ->max($maxLength)
            ->getErrors()
        );
    }
    
    public function providerMax()
    {
        return [
            [[], '123', 61],
            [['' => 'У поля  многовато цифр'], 123, 61],
            [[], 61, 123],
            [['' => 'У поля  многовато символов'], 'oleg', 3],
            [[], '', 60],
        ];
    }
}
