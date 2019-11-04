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
	private $value;
	/**
	 * @var array
	 */
	private $errors;
	private $name;
	
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
	public static function maxLength($string, $minLength = self::MAX_LENGTH_OF_FIELD, $hardCheck = true)
	{
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
	public static function email($email)
	{
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
	
	public function setValue($value)
	{
		$this->value = $value;
		return $this;
		
	}
	
	public function required()
	{
		
		if ($this->value == '' || $this->value == null) {
			$this->errors[] = 'Поле ' . $this->name . ' Пустое';
		}
		return $this;
		
	}
	
	public function setName($name)
	{
		$this->name = $name;
		return $this;
		
	}
	
	public function min($minLength = self::MIN_LENGTH_OF_FIELD)
	{
		if (is_string($this->value)) {
			if (strlen($this->value) < $minLength) {
				$this->errors[] = 'У поля ' . $this->name . ' маловато символов';
			}
		} else {
			if ($this->value < $minLength) {
				$this->errors[] = 'У поля ' . $this->name . ' маловато цифр';
			}
		}
		return $this;
		
	}
	
	public function max($maxLength = self::MAX_LENGTH_OF_FIELD)
	{
		if (is_string($this->value)) {
			
			if (strlen($this->value) > $maxLength) {
				$this->errors[] = 'У поля ' . $this->name . ' многовато мисволов';
			}
			
		} else {
			
			if ($this->value > $maxLength) {
				$this->errors[] = 'У поля ' . $this->name . ' многовато цифр';
			}
			
		}
		return $this;
		
	}
	public function isExist() {
		if (User::isEmailExist($this->value)) {
			$this->errors[] = 'Email занят';
		}
		return $this;
	}
	
}
