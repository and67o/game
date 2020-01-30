<?php

namespace Router\Models;

use PHPUnit\Framework\TestCase;
use Router\src\classes\model\Game;

class GameTest extends TestCase
{
//	/**
//	 * @param $expected
//	 * @param $number
//	 * @param $gameNumber
//	 * @dataProvider providerCheckNumber
//	 */
//	public function testCheckNumber($expected, $number, $gameNumber)
//	{
//		$Game = new Game($gameNumber);
//		$this->assertSame($expected, $Game->checkNumber($number));
//	}
//
//	public function providerCheckNumber()
//	{
//		return [
//			[['rightPosition' => 0, 'rightCount' => 0, 'youWin' => false], 1, false],
//			[['rightPosition' => 0, 'rightCount' => 0, 'youWin' => false], 5678, 1234],
//			[['rightPosition' => 1, 'rightCount' => 2, 'youWin' => false], 2638, 1234],
//			[['rightPosition' => 1, 'rightCount' => 2, 'youWin' => false], 4638, 1234],
//			[['rightPosition' => 4, 'rightCount' => 4, 'youWin' => true], 1234, 1234],
//		];
//	}
//
	/**
	 * @param $expected
	 * @dataProvider providerCreateGame
	 */
	public function testCreateGame($expected)
	{
		$observer = $this->getMockBuilder(Game::class)
			->setMethods(['createGame', 'writeNumber'])
			->disableOriginalConstructor()
			->getMock();
		
		$observer->expects($this->any())
			->method('createGame')
			->will($this->returnValue(1213));
		
		$observer->expects($this->any())
			->method('writeNumber')
			->will($this->returnValue('nastya'));
		
		$result = $observer->createFullGame(123);
		$this->assertSame($expected, $result);
	}
	
	public function providerCreateGame()
	{
		return [
			[true]
		];
	}
}
