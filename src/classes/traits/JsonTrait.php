<?php


namespace Router\Traits;

/**
 * Trait JsonTrait
 * @package Router\Traits
 */
trait JsonTrait
{
	/**
	 * @param $var
	 * @param bool $send
	 * @return false|string
	 */
	public function toJSON($var, $send = false)
	{
		$result = json_encode($var);
		if ($send) {
			header('Content-Type: application/json; charset=utf-8');
			print($result);
			exit();
		}
		return $result;
	}
	
	/**
	 * @param $var
	 * @param bool $mask
	 * @return mixed
	 */
	public function fromJSon($var, bool $mask)
	{
		return json_decode($var, $mask);
	}
}
