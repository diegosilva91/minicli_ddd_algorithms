<?php

namespace AK\Tests;
use \PHPUnit\Framework\TestCase;

/**
 *
 */
class PruebaTest extends TestCase
{

	public function testFrameworkConfigured()
	{
		$this->assertTrue(true);
	}

	public function testTresEnRayaNotResolved()
	{
		$array=[[0,0,1],
            [0,1,2],
            [2,1,0]];
	    $this->assertEquals(boardState($array), -1);
	}
    public function testTresEnRayaPlayer1()
    {
        $array=[[0,1,1],
            [0,1,2],
            [2,1,0]];
        $this->assertEquals(boardState($array), 1);
    }
    public function testTresEnRayaPlayer2()
    {
        $array=[[2,0,1],
            [2,1,2],
            [2,1,0]];
        $this->assertEquals(boardState($array), 2);
    }
    public function testTresEnRayaTwoPlayers()
    {
        $array=[[2,1,1],
            [2,1,2],
            [2,1,0]];
        $this->assertEquals(boardState($array), 0);
    }
}

