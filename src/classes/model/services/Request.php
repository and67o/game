<?php


namespace Router\Models\Services;


use Exception;

/**
 * Class Request
 * @package Router\Models\Services
 */
class Request
{
	/**
	 * @param string $url
	 * @return bool|string
	 * @throws Exception
	 */
	public static function curl(string $url)
	{
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		
		$result = curl_exec($ch);
		if (!$result) {
			$errno = curl_errno($ch);
			$error = curl_error($ch);
		}
		
		curl_close($ch);
		
		if (isset($errno) && isset($error)) {
			throw new Exception($error, $errno);
		}
		
		return $result;
	}
}