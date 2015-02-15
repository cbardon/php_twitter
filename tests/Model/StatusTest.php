<?php

namespace Modele;

$loader = require _DIR_.'/../../vendor/autoload.php';

class StatusTest extends \PHPUnit_Framework_TestCase
{
	private $status

	public function _construct()
	{
	}

	public function test_construct()
	{
		$this->$Status = new Status("115",new \Model\User(null,"test","test"),"yeap");
		$this->assertNotNull($this->Status);
	}

	public function test_construct2()
	{
		$this->$Status = new Status("115",new \Model\User(null,"test","test"),"yeap");
		$this->assertEquals("yeap",$this->Status->getStatus());
	}

	public function testGetId()
	{
		$this->Status = new Status("115",new \Model\User(null,"test","test"),"yeap");
		$this->assertEquals("115",$this->Status->getId());
	}

	public function testGetName()
	{
		$this->Status = new Status("115",new \Model\User(null,"test","test"),"yeap");
		$this->assertEquals("test",$this->Status->getName());
	}

	public function testGetText()
	{
		$this->Status = new Status("115",new \Model\User(null,"test","test"),"yeap");
		$this->assertEquals("test",$this->Status->getText());
	}


}
