<?php

namespace Model;

$loader = require _DIR_ . '/../../vendor/autoload.php';

class UserTest extends \PHPUnit_Framework_TestCase
{

	private $user;

	public function _construct()
	{
	}

	public function testGetId()
	{
		$this->User = new User(null,"test","test");
		$this->assertEquals(null, $this->User-getId());
	}
	

	public function testGetName()
	{
		$this->User = new User(null,"test","test");
		$this->assertEquals("test", $this->User-getName());
	}

	public function testGetPassword()
	{
		$this->User = new User(null,"test","test");
		$this->assertEquals(null, $this->User-getPassword());
	}
}
