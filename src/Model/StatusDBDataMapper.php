<?php

namespace Model;

class StatusDBDataMapper
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
	public function persist(Status $objStatus) {
		$query = "INSERT INTO statuses VALUES (:id, :author, :tweet, :dateT)";
		
		$params = array( 'id' => 0,
						 'author' => $objStatus->getAuthor(),
						 'tweet' => $objStatus->getMessage(),
						 'dateT' => $objStatus->getDate()
						);	
		
		$res = $this->con->executeQuery($query, $params);
		
		return $res;
	}
	
	/**
	 * Delete a status by is ID
	 */
	public function remove($id) {
		$query = "DELETE FROM statuses WHERE id = :id";
		
		$params = array('id' => $id);
		
		$res = $this->con->executeQuery($query, $params);
	}
	
}
