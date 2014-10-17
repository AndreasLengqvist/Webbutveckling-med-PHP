<?php

namespace model;


class Members{

	private $members;



	public function __construct(){
		$this->members = array();
	}


	public function getMembers(){
		return $this->members;
	}


	public function addMembers(Member $member){
		$this->members[] = $member;
	}
}