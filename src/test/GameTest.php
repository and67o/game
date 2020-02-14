<?php


use PHPUnit\Framework\TestCase;
use Router\Models\Game;

class GameTest extends TestCase
{
	/**
	 * @param $expected
	 * @param $number
	 * @param $gameNumber
	 * @dataProvider providerCheckNumber
	 */
	public function testCheckNumber($expected, $number, $gameNumber)
	{
		$Game = new Game($gameNumber);
		$this->assertSame($expected, $Game->checkNumber($number));
	}

	public function providerCheckNumber()
	{
		return [
			[['rightPosition' => 0, 'rightCount' => 0, 'youWin' => false], 5678, 1234],
			[['rightPosition' => 1, 'rightCount' => 2, 'youWin' => false], 2638, 1234],
			[['rightPosition' => 1, 'rightCount' => 2, 'youWin' => false], 4638, 1234],
			[['rightPosition' => 4, 'rightCount' => 4, 'youWin' => true], 1234, 1234],
		];
	}

}
