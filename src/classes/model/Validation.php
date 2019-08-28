<?php


namespace Router\src\classes\model;


class Validation
{
	const MIN_LENGTH_OF_FIELD = 3;

	static public function minLength($string, $minLength = self::MIN_LENGTH_OF_FIELD, $hardCheck = true)
	{
		if (!$string || !$minLength) {
			return false;
		}
		$length = strlen($string);
		return $hardCheck ? $length < $minLength : $length <= $minLength;
	}
}
