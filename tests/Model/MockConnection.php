<?php

namespace test/Model;

class MockConnection extends Connection
{
    public function __construct()
    {
    }

	public function executeQuery($query, array $parameters = [])
	{
	$stmt = $this->prepare($query);
	foreach($parameters as $name => $value){
	$stmt->bindValue($ane,$value);
		}

	return $stmt;
	}
}
