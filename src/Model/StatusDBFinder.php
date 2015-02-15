<?php

namespace Model;

use Model\Status;

class StatusDBFinder
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
		$query = "SELECT * FROM statuses WHERE id = :id";
		
		$res = $this->con->executeQuery($query, array('id' => $id));
		
		return $res;
	}
	
	/**
     * Returns all elements.
     *
     * @return array
     */
    public function findAll($request = null)
    {
		$query = "SELECT * FROM statuses";
		
		if ($request != null) {
			
			$limit = $request->getParameter('limit');
			$orderBy = $request->getParameter('orderBy');
			$direction = $request->getParameter('direction');
			$auteur = $request->getParameter('auteur');
			
			if ($auteur != null) {
				$query .= " WHERE auteur = '" . $auteur . "'";
			}
			
			if ($orderBy != null && ($orderBy == 'auteur' || $orderBy == 'commentaire' || $orderBy == 'dateC')) {
				$query .= " ORDER BY " . $orderBy;
			} else {		
				$query .= " ORDER BY dateC";
			}
			
			if ($direction != null && ($direction == 'ASC' || $direction == 'DESC')) {
				$query .= " " . $direction;
			} else {
				$query .= " DESC";
			}
			
			if ($limit != null && is_numeric($limit)) {
				$query .= " LIMIT 0, " . $limit;
			}
			
		}
		
		$res = $this->con->executeQuery($query);
		
		return $res;
	}
}
