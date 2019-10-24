<?php


namespace Router\src\classes\model;


use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

class Validation
{
	const MIN_LENGTH_OF_FIELD = 3;
	
	/**
	 * проверка на минимальную длину
	 * @param $string
	 * @param int $minLength
	 * @param bool $hardCheck
	 * @return bool
	 */
	static public function minLength($string, $minLength = self::MIN_LENGTH_OF_FIELD, $hardCheck = true)
	{
		if (!$string || !$minLength) {
			return false;
		}
		$length = strlen($string);
		return $hardCheck ? $length < $minLength : $length <= $minLength;
	}
	
	/**
	 * Валидация email
	 * @param string $email
	 * @return bool
	 */
	public static function isValidateEmail($email) : bool
	{
		if (!$email) {
			return false;
		}
		$EmailValidator = new EmailValidator();
		return $EmailValidator->isValid($email, new RFCValidation());
		
	}
	
	static public function password()
	{
		return true;
	}
}
