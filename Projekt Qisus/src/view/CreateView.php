<?php

namespace view;

require_once("src/model/Quiz.php");
require_once("NavigationView.php");


class CreateView{

	private $errorMessage;
	private $session;
	private static $title = 'title';
	private static $creator = 'creator';
	private static $submitTitle = 'submitTitle';
	private static $submitCreator = 'submitCreator';
	private static $back = 'back';



	public function __construct(\model\CreateSession $session){
		$this->session = $session;
	}


	public function submitTitle(){
		return isset($_POST[self::$submitTitle]);
	}

	public function submitCreator(){
		return isset($_POST[self::$submitCreator]);
	}

	public static function back(){
		return isset($_POST[self::$back]);
	}


	public function getTitle(){
		if($this->submitTitle()){
			$title = trim($_POST[self::$title]);
			if (empty($title)) {
				$this->errorMessage = "<p id='error_message'>Ditt quiz måste heta något! ;)</p>";
				return null;
			}
			return $title;
		}
	}


	public function getQuizData($title){
		if($this->submitCreator()){

			try {
				return new \model\Quiz(NULL, $title, $_POST[self::$creator]);
			} catch (\Exception $e) {
				$this->errorMessage = "<p id='error_message'>" . $e->getMessage() . "</p>";
			}
		}
	}


	public function showCreateTitle(){

		$errorMessage = $this->errorMessage;
		$title = "";
		if ($this->session->titleSessionIsset()) {
			$title = $this->session->getTitleSession();
		}

		$ret = "
					<h1 id='tiny_header'>qisus.</h1>
					<h1 id='big_header'>qisus.</h1>
					<div id='center_wrap'>
						<form method='post'>
							<div>
								<label id='title_label' for='title_input'>Vad ska quizet heta?</label>
							</div>
							<div>
								<input id='title_input' type='text' name='" . self::$title . "' value='$title'>
							</div>

								$errorMessage

		    				<div>
								<input class='continueButton' type='submit' value='Fortsätt →' name='" . self::$submitTitle . "'>
							</div>
						</form>
					</div>
				";

		return $ret;
	}


	public function showCreateCreator(){

		$errorMessage = $this->errorMessage;

		$ret = "
					<h1 id='tiny_header'>qisus.</h1>
					<h1 id='big_header'>qisus.</h1>
					<div id='center_wrap'>
						<form method='post'>
							<div>
								<label id='title_label' for='title_input'>Skriv in din email..</label>
							</div>
							<div>
								<input id='title_input' type='text' maxlength='255' name=' " . self::$creator . "'>
							</div>

								$errorMessage

		    				<div>
								<input class='backButton' type='submit' value='← Tillbaka' name='" . self::$back . "'>
								<input class='continueButton' type='submit' value='Fortsätt →' name='" . self::$submitCreator . "'>
							</div>
						</form>
					</div>
				";

		return $ret;
	}
}