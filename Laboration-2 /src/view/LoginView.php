<?php


class LoginView{
	
	private $model;

	public function __construct(LikeModel $model){
		$this->model = $model;
	}
}