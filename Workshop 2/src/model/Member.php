<?php

namespace model;



class Member{

	private $memberId;
	private $firstname;
	private $lastname;
	private $persId;



	// Sätter medlemmens uppgifter och slumpar fram ett unikt medlemsid för denne.
	public function __construct($memberId = NULL, $firstname, $lastname, $persId){

		if (empty($firstname) or empty($lastname) or empty($persId)) {
			throw new \Exception("Fälten får inte vara tomma.");
		}

		$this->firstname = $firstname;
		$this->lastname = $lastname;
		$this->persId = $persId;
		$this->memberId = ($memberId == NULL) ? sha1(uniqid($this->persId, true)) : $memberId;
	}


	public function getMemberId(){
		return $this->memberId;
	}


	public function getPersId(){
		return $this->persId;
	}


	public function getFirstname(){
		return $this->firstname;
	}


	public function getLastname(){
		return $this->lastname;
	}


	public function isValid(){
		return isset($this->memberId) and isset($this->firstname) and isset($this->lastname) and isset($this->persId);
	}
}