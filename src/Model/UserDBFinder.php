<?php

namespace Model;

use Model\User;

class UserDBFinder
{	
	/**
	 * @var Connection
	 */
	private $con;
	
	/**
	 * The constructor of the class
	 */
	public function __construct($con) {
		$this->con = $con;
	}

	/**
     * Retrieve an element by its id.
     *
     * @param  mixed      $id
     * @return null|mixed
     */
    public function findOneById($id)
    {
		$query = "SELECT * FROM users WHERE id = :id";
		
		$res = $this->con->executeQuery($query, array('id' => $id));
		
		return $res;
	}
	
	/**
     * Retrieve an user by its name.
     *
     * @return array
     */
    public function findOneByIsName($name)
    {
		$query = "SELECT * FROM users WHERE name = :name";
		
		$res = $this->con->executeQuery($query, array('name' => $name));
		
		return $res;
	}
	
	/**
	 * Verify if the user name and password match
	 * 
	 * @return array
	 */
	public function findIfGoodUser(User $user) {
		$query = "SELECT * FROM users WHERE name = :name AND password = :password";
		
		$params = array('name' => $user->getName(), 'password' => $user->getPassword());
		
		$res = $this->con->executeQuery($query, $params);
		
		return $res;		
	}
}
