<?php

use PHPUnit\Framework\TestCase;
use Router\Db;

class DbTest extends TestCase
{
    /**
     * @param $expected
     * @param $select
     * @param $table
     * @param $where
     * @dataProvider providerSetQuery
     */
    public function testSetSelectQuery($expected, $select, $table, $where)
    {
        $observer = $this->getMockBuilder(Db::class)
            ->setMethods(['getFields', 'getTable', 'getWhere'])
            ->disableOriginalConstructor()
            ->getMock();
        
        $observer->expects($this->once())
            ->method('getFields')
            ->will($this->returnValue($select));
        $observer->expects($this->once())
            ->method('getTable')
            ->will($this->returnValue($table));
        $observer->expects($this->once())
            ->method('getWhere')
            ->will($this->returnValue($where));
        
        /* @var $observer Db */
        $this->assertSame($expected, $observer->setSelectQuery());
    }
    
    public function providerSetQuery()
    {
        return [
            [
                'SELECT game_number FROM game_numbers WHERE g_id = ?',
                ['game_number'], ['game_numbers'], ['g_id = ?']
            ],
            [
                'SELECT * FROM game_numbers WHERE g_id = ? AND id = ?',
                ['*'], ['game_numbers'], ['g_id = ?', 'id = ?']
            ],
            //TODO на пустом where должно быть where 1
            [
                'SELECT * FROM game_numbers WHERE ',
                ['*'], ['game_numbers'], ['']
            ],
        ];
    }
    
    /**
     * @param $expected
     * @param $params
     * @param $table
     * @dataProvider providerSetInsertQuery
     */
    public function testSetInsertQuery($expected, $params, $table)
    {
        $observer=$this->getMockBuilder(Db::class)
            ->setMethods(['getTable'])
            ->disableOriginalConstructor()
            ->getMock();
        
        $observer->expects($this->once())
            ->method('getTable')
            ->will($this->returnValue($table));
        
        /* @var $observer Db */
        $this->assertSame($expected, $observer->setInsertQuery($params));
    }
    
    public function providerSetInsertQuery()
    {
        return [
            [
                'INSERT INTO table (`g_id`, `user_id`) VALUES (?, ?)',
                ['g_id'=>1, 'user_id'=>2,], ['table']
            ]
        ];
    }
}

