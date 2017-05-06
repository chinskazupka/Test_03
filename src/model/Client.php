<?php


/**
* Class client build an instance of a client
*/
class Client{

	/* Client name (prenom) */
	protected $name;
	/* Client surname (nom) */
	protected $surname;
	/* Client email */
	protected $email;
	/* Client status */
	protected $status;
	/* Client telephone */
	protected $telephone;


	public function __construct($name, $surname, $email, $status, $telephone)
	{
		$this->name=$name;
		$this->surname=$surname;
		$this->email=$email;
		$this->status=$status;
		$this->telephone=$telephone;
	}


	/* GETTERS */
	public function getName(){return $this->name;}
	public function getSurname(){return $this->surname;}
	public function getEmail(){return $this->email;}
	public function getStatus(){return $this->status;}
	public function getTelephone(){return $this->telephone;}

}

?>