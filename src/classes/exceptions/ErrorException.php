<?php


namespace Router\Exceptions;


use Router\Traits\Json;

/**
 * Class ErrorException
 * @package Router\Exceptions
 */
class ErrorException extends BaseException
{
	use Json;
	
	/**
	 * ErrorException constructor.
	 * @param string $errors
	 * @param int $code
	 * @param \Exception|null $previous
	 */
	public function __construct($errors = "", $code = 0, \Exception $previous = null)
	{
		$this->toJSON([
			'errors' => $errors,
			'result' => false,
			'data' => []
		], true);
		parent::__construct('', $code, $previous);
	}
	
}
