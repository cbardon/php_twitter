<?php

namespace Model;

class Status
{
	/**
	 * @var int
	 */
	private $id;
	
	/**
	 * @var String
	 */
	private $author;
	
	/**
	 * @var String
	 */
	private $message;
	
	/**
	 * @var date
	 */
	private $date;
	
	/**
	 * The constructor of the Status class
	 */
	public function __construct($author, $message, $date = null) {
		$this->author = $author;
		$this->message = $message;
		$this->date = $date;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getAuthor() {
		return $this->author;
	}
	
	public function getMessage() {
		return $this->message;
	}
	
	public function getDate() {
		return $this->date;
	}
	
	
	
}
