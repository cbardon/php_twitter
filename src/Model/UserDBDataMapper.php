<?php

namespace Model;

class UserDBDataMapper
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
	 * Add a status
	 */
	public function persist(User $objUser) {
		$query = "INSERT INTO users VALUES (:id, :name, :password)";
		
		$params = array( 'id' => 0,
						 'name' => $objUser->getName(),
						 'password' => $objUser->getPassword()
						);	
		
		$res = $this->con->executeQuery($query, $params);

		return $res;
	}
	
	/**
	 * Delete a status by is ID
	 */
	public function remove($id) {
		$query = "DELETE FROM users WHERE id = :id";
		
		$params = array('id' => $id);
		
		$res = $this->con->executeQuery($query, $params);
	}
	
}
