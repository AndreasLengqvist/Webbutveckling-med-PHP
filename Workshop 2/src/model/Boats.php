<?php

namespace model;


class Boats{

	private $boats;



	public function __construct(){
		$this->boats = array();
	}


	public function getBoats(){
		return $this->boats;
	}


	public function addBoats(Boat $boat){
		$this->boats[] = $boat;
	}
}