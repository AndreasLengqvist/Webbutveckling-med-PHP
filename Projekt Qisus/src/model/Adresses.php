<?php

namespace model;

require_once("QuizRepository.php");


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