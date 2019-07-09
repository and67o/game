<?php

namespace Router\src\classes\model;


class GameTest extends \PHPUnit_Framework_TestCase
{

	public function testCheckRightPosition($expected, $computerNumber, $myNumber)
	{
		$Game = new Game($computerNumber);
		$this->assertAquls();
	}
}
