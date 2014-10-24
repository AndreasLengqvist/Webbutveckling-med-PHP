<?php

namespace model;

/**
* Skapar en lista(array) av Adress-objekt.
*/
class Adresses{

	private $adresses;



	public function __construct(){
		$this->adresses = array();
	}


	public function getAdresses(){
		return $this->adresses;
	}


	public function addAdresses(Adress $adress){
		$this->adresses[] = $adress;
	}
}