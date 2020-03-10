<?php


namespace Router\Models;


use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

class Validation extends Model
{
	const MIN_LENGTH_OF_FIELD = 3;
	const MAX_LENGTH_OF_FIELD = 60;
	
	private $value;
	private $errors = [];
	private $name;
	
	/**
	 * Валидация email
     * @unitTest
	 * @return Validation
	 */
	public function isValidateEmail() : Validation
	{
		$EmailValidator = new EmailValidator();
		if (!$EmailValidator->isValid($this->value, new RFCValidation())) {
			$this->errors[$this->name] = 'Email набран некорректно';
		};
		
		return $this;
	}
	
	/**
	 * записать значение
	 * @param $value
	 * @return Validation
	 */
	public function setValue($value) :Validation
	{
		$this->value = $value;
		return $this;
	}
	
	/**
	 * получить значение
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}
    
    /**
     * Обязательное поле
     * @phpUnit
     * @return Validation
     */
	public function required() :Validation
	{
		if (in_array($this->getValue(), ['', null], true)) {
			$nameField = $this->getName();
			$this->errors[$nameField] = 'Поле ' .$nameField . ' Пустое';
		}

		return $this;
	}
	
	/**
	 * Записать поле
	 * @param $name
	 * @return $this
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}
	
	/**
	 * Получить название поля
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * Минимальное кол-во символов
     * @phpUnit
	 * @param int $minLength
	 * @return $this
	 */
	public function min($minLength = self::MIN_LENGTH_OF_FIELD)
	{
	    $value = $this->getValue();
        $name = $this->getName();
        
        if (is_string($value) || !$value) {
			if (strlen($value) < $minLength) {
				$this->errors[$name] = 'У поля маловато символов';
			}
		} else {
			if ($value < $minLength) {
				$this->errors[$name] = 'У поля маловато цифр';
			}
		}
		return $this;
		
	}
	
	/**
	 * Максимальное кол-во символов
     * @phpUnit
	 * @param int $maxLength
	 * @return $this
	 */
	public function max($maxLength = self::MAX_LENGTH_OF_FIELD)
	{
        $value = $this->getValue();
        $name = $this->getName();
        
		if (is_string($value)) {
			if (strlen($value) > $maxLength) {
				$this->errors[$name] = 'У поля ' . $name. ' многовато символов';
			}
		} else {
			if ($value > $maxLength) {
				$this->errors[$name] = 'У поля ' . $name . ' многовато цифр';
			}
		}
		return $this;
	}
	
	/**
	 * проверка на существование email
	 * @return $this
	 */
	public function isExist()
	{
		if (User::isEmailExist($this->getValue())) {
			$this->errors[$this->getName()] = 'Email занят';
		}
		return $this;
	}
	
	/**
	 * есть ли ошибки
	 * @return bool
	 */
	public function isSuccess()
	{
		return empty($this->errors);
	}
	
	/**
	 * @return array
	 */
	public function getErrors()
	{
		if (!$this->isSuccess()) {
			return $this->errors;
		}
		return [];
	}
	
}
