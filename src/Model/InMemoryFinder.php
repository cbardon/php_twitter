<?php

namespace Model;

class InMemoryFinder implements FinderInterface
{
	 /**
     * @var array
     */
	private $fake = array("Ceci est un status", "Bien le bonjour tout le monde", "kdsjgslkdkdsjhgdk");
	
	/**
     * Returns all elements.
     *
     * @return array
     */
    public function findAll()
    {
		return $this->fake;
	}

    /**
     * Retrieve an element by its id.
     *
     * @param  mixed      $id
     * @return null|mixed
     */
    public function findOneById($id)
    {
		return $this->fake[$id];
	}
}
