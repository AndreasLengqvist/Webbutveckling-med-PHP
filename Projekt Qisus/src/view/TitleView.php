<?php

namespace view;

require_once("src/model/Quiz.php");
require_once("NavigationView.php");


class TitleView{

	private $session;
	private static $title = 'title';
	private static $submit = 'submit';



	public function submitTitle(){
		return isset($_POST['submit']);
	}


	public function getTitle(){
		if(empty($_POST[self::$title])){
			throw new \Exception("Hörrö, ditt quiz måste heta något! ;)");
		}
		return new \model\Quiz(NULL, $_POST[self::$title]);
	}


	public function show(){

		$ret = "
					<h3>qisus.</h3>
					<div id='title_wrap'>
						<form action='?".NavigationView::$action."=".NavigationView::$actionAddTitle."' method='post'>
							<label id='title_label' for='title'>Vad ska quizet heta?</label><br>
							<input id='title' type='text' name='" . self::$title . "'><br>
							<input id='finishbutton' type='submit' value='Fortsätt →' name='" . self::$submit . "'>
						</form>
					</div>
				";

		return $ret;
	}
}