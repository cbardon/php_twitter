<?php

namespace Model;

class DatabaseAccess extends \PDO
{
	public function __construct($dbhost, $dbname, $dbuser = 'root', $dbpass = '', $dbtype = 'mysql') {
		try {
			parent::__construct($dbtype . ':host=' . $dbhost . ';dbname=' . $dbname, $dbuser, $dbpass);
		} catch (PDOException $e) {
			echo "There is a little probleme whit the Databases ! : " . $e->getMessage();
		}
    } 

	public function executeQuery($query, array $parameters = []) {
		$stmt = $this->prepare($query);
		
		foreach ($parameters as $name => $value) {
			$stmt->bindValue(':' . $name, $value);
		}
		
		$stmt->execute();

		return $stmt->fetchAll();
	}
	
}
