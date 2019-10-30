<?php


namespace Router\src\classes\model;


use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;
use Router\Models\User;

class Validation extends Model
{
	
//	public function __construct()
//	{
//		$this->_db = Db::getInstance();
//	}
	
	const MIN_LENGTH_OF_FIELD = 3;
	const MAX_LENGTH_OF_FIELD = 60;
	
	/**
	 * проверка на минимальную длину
	 * @param $string
	 * @param int $minLength
	 * @param bool $hardCheck
	 * @return bool
	 */
	public static function minLength($string, $minLength = self::MIN_LENGTH_OF_FIELD, $hardCheck = true)
	{
		if (!$string) {
			return false;
		}
		$length = strlen($string);
		return $hardCheck ? $length < $minLength : $length <= $minLength;
	}
    /**
     * проверка на максимальную длину
     * @param $string
     * @param int $minLength
     * @param bool $hardCheck
     * @return bool
     */
	public static function maxLength($string, $minLength = self::MAX_LENGTH_OF_FIELD, $hardCheck = true) {
		if (!$string) {
			return false;
		}
		$length = strlen($string);
		return $hardCheck ? $length > $minLength : $length >= $minLength;
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
	
	/**
	 * Валидация email
	 * @param $email
	 * @return string
	 */
	public static function email($email) {
		if (!$email) {
			return 'Введите email';
		} elseif (self::minLength($email)) {
			return 'Мало символов';
		} elseif (self::maxLength($email)) {
			return 'Много символов';
		} elseif (User::isEmailExist($email)) {
			return 'Email занят';
		} elseif (self::isValidateEmail($email)) {
			return 'Email набран некорректно';
		}
		return '';
	}
	
	static public function password($password)
	{
		return true;
	}
}
