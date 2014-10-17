<?php

namespace model;



class Boat{

	private $memberId;
	private $boatId;
	private $boattype;
	private $length;



	// Sätter medlemmens uppgifter och slumpar fram ett unikt medlemsid för denne.
	public function __construct($memberId, $boatId = NULL, $boattype, $length){

		$this->memberId = $memberId;
		$this->boatId = ($boatId == NULL) ? sha1(uniqid($this->memberId, true)) : $boatId;
		$this->length = $length;
		$this->boattype = $boattype;
	}


	public function getMemberId(){
		return $this->memberId;
	}


	public function getBoatId(){
		return $this->boatId;
	}


	public function getBoattype(){
		return $this->boattype;
	}


	public function getLength(){
		return $this->length;
	}


	public function isValid(){
		return isset($this->memberId) and isset($this->boatId) and isset($this->boattype) and isset($this->length);
	}
}