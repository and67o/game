<?php


namespace Router\Exceptions;

use Exception;

/**
 * Class InstanceNotFound
 * @package Exceptions
 */
class InstanceNotFound extends BaseException
{
	/**
	 * InstanceNotFound constructor.
	 * @param string $message
	 * @param int $code
	 * @param Exception|null $previous
	 */
	public function __construct(string $message = '', int $code = self::BASE_ERROR, Exception $previous = null)
	{
		parent::__construct($code, $message, $previous);
	}
}