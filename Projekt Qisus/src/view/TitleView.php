<?php

namespace view;

require_once("src/model/Quiz.php");
require_once("NavigationView.php");


class TitleView{

	private $errorMessage;
	private static $title = 'title';
	private static $submit = 'submit';
	private static $back = 'back';



	public function submitTitle(){
		return isset($_POST['submit']);
	}


	public function getQuizData(){
		if($this->submitTitle()){
			$title = trim($_POST[self::$title]);
			if (empty($title)) {
				$this->errorMessage = "<p id='error_message'>Ditt quiz måste heta något! ;)</p>";
				return null;
			}
			return new \model\Quiz(NULL, $title);
		}
	}


	public function show(){

		$errorMessage = $this->errorMessage;


		$ret = "
					<h1 id='tiny_header'>qisus.</h1>
					<h1 id='big_header'>qisus.</h1>
					<div id='center_wrap'>
						<form method='post'>
							<div>
								<label id='title_label' for='title_input'>Vad ska quizet heta?</label>
							</div>
							<div>
								<input id='title_input' type='text' name='" . self::$title . "'>
							</div>

								$errorMessage

		    				<div>
								<input class='continueButton' type='submit' value='Fortsätt →' name='" . self::$submit . "'>
							</div>
						</form>
					</div>
				";

		return $ret;
	}
}