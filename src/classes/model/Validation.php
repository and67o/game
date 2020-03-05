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
	 * записание значение
	 * @param $value
	 * @return $this
	 */
	public function setValue($value)
	{
		$this->value = $value;
		return $this;
	}

	/**
	 * Обязательное поле
	 * @return $this
	 */
	public function required()
	{
		if ($this->value == '' || $this->value == null) {
			$this->errors[$this->name] = 'Поле ' . $this->name . ' Пустое';
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
	 * Минимальное кол-во символов
	 * @param int $minLength
	 * @return $this
	 */
	public function min($minLength = self::MIN_LENGTH_OF_FIELD)
	{
		if (is_string($this->value)) {
			if (strlen($this->value) < $minLength) {
				$this->errors[$this->name] = 'У поля маловато символов';
			}
		} else {
			if ($this->value < $minLength) {
				$this->errors[$this->name] = 'У поля маловато цифр';
			}
		}
		return $this;

	}

	/**
	 * Максимальное кол-во символов
	 * @param int $maxLength
	 * @return $this
	 */
	public function max($maxLength = self::MAX_LENGTH_OF_FIELD)
	{
		if (is_string($this->value)) {
			if (strlen($this->value) > $maxLength) {
				$this->errors[$this->name] = 'У поля ' . $this->name . ' многовато символов';
			}
		} else {
			if ($this->value > $maxLength) {
				$this->errors[$this->name] = 'У поля ' . $this->name . ' многовато цифр';
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
	    //TODO один ответ
		if (User::isEmailExist($this->value)) {
			$this->errors[$this->name] = 'Email занят';
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
