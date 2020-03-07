<?php


namespace Router\Exceptions;


use Router\Traits\JsonTrait;
use Throwable;

class ErrorException extends BaseException
{
	use JsonTrait;
	
	public function __construct($errors = "", $code = 0, Throwable $previous = null)
	{
		$this->toJSON([
			'errors' => $errors,
			'result' => false,
			'data' => []
		], true);
		parent::__construct('', $code, $previous);
	}
	
}
