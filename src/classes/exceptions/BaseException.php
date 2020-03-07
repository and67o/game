<?php


namespace Router\Exceptions;

use Exception;


class BaseException extends Exception
{
	const WRONG_METHOD = 1;
	const BASE_ERROR = 0;
	const WRONG_AUTH = 3;
	const USER_NOT_FOUND = 4;
	
	/**
	 * Ошибки исключений
	 */
	const BASE_EXCEPTION = [
		self::BASE_ERROR => 'Что-то не так',
		self::WRONG_METHOD => 'Не тот метод',
		self::WRONG_AUTH => 'Ошибка авторизации',
		self::USER_NOT_FOUND => 'Пользователь не найден'
	];
	
	/**
	 * Базовое исключение
	 * BaseException constructor.
	 * @param int $code
	 * @param string $message
	 * @param Exception $previous
	 */
	public function __construct(
		$code = self::BASE_ERROR,
		$message = '',
		Exception $previous = null
	)
	{
		parent::__construct($message, $code, $previous);
	}
	
	/**
	 * Вернуть текст ошибки
	 * @return string
	 */
	public function getTextError() : string
	{
		$code = $this->getCode();
		return
			self::BASE_EXCEPTION[$code] ??
			self::BASE_EXCEPTION[self::BASE_ERROR];
	}
}