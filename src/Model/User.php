<?php

namespace Model;

class User
{
	/**
	 * @var int
	 */
	private $id;
	
	/**
	 * @var String
	 */
	private $name;
	
	/**
	 * @var String
	 */
	private $password;
	
	/**
	 * The constructor of the User class
	 */
	public function __construct($name, $password) {
		$this->name = $name;
		$this->password = $password;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getPassword() {
		return $this->password;
	}
}
