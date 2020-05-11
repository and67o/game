<?php


namespace Router\Exceptions;

use Exception;

/**
 * Class BaseException
 * @package Router\Exceptions
 */
class BaseException extends Exception
{
	const WRONG_METHOD = 1;
	const BASE_ERROR = 0;
	const WRONG_AUTH = 3;
	const USER_NOT_FOUND = 4;
	const GAME_NOT_CREATED = 5;
	const NO_NUMBER = 6;
	const UNKNOWN_SOCIAL_NETWORK = 7;
	const WRONG_REQUEST = 8;
	const USER_NOT_CREATED = 9;
	
	/**
	 * Ошибки исключений
	 */
	const BASE_EXCEPTION = [
		self::BASE_ERROR => 'Что-то не так',
		self::WRONG_METHOD => 'Не тот метод',
		self::WRONG_AUTH => 'Ошибка авторизации',
		self::USER_NOT_FOUND => 'Пользователь не найден',
		self::GAME_NOT_CREATED => 'Игра не создана',
		self::NO_NUMBER => 'Число не добавлено',
		self::UNKNOWN_SOCIAL_NETWORK => 'Неизвестная социальная сеть',
		self::WRONG_REQUEST => 'Неверный запрос',
		self::USER_NOT_CREATED => 'Проблемы с регистрацией'
	];
	
	/**
	 * Базовое исключение
	 * BaseException constructor.
	 * @param int $code
	 * @param string $message
	 * @param Exception $previous
	 */
	public function __construct(
		int $code = self::BASE_ERROR,
		string $message = '',
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
