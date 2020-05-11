<?php


namespace Router\Models\Services;


use Exception;
use Router\Exceptions\BaseException;

/**
 * Class Request
 * @package Router\Models\Services
 */
class Request
{
	
	const METHOD_GET = 'GET';
	const METHOD_POST = 'POST';
	const METHOD_PUT = 'PUT';
	const METHOD_DELETE = 'DELETE';
	const METHOD_PATCH = 'patch';
	
	/**
	 * @param string $url
	 * @param string $method
	 * @return bool|string
	 * @throws BaseException
	 */
	public function curl(string $url, string $method = self::METHOD_GET)
	{
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		self::setMethod($method, $ch);
		
		$result = curl_exec($ch);
		if (!$result) {
			$errno = curl_errno($ch);
			$error = curl_error($ch);
		}
		
		curl_close($ch);
		
		if (isset($errno) && isset($error)) {
			throw new BaseException(BaseException::WRONG_REQUEST);
		}
		
		return $result;
	}
	
	/**
	 * @param string $method
	 * @param $ch
	 */
	public static function setMethod(string $method, $ch) : void
	{
		switch ($method) {
			case self::METHOD_POST:
				curl_setopt($ch, CURLOPT_POST, 1);
				break;
			case self::METHOD_DELETE:
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
				break;
			case self::METHOD_PUT:
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
				break;
			case self::METHOD_PATCH:
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
				break;
		}
	}
}