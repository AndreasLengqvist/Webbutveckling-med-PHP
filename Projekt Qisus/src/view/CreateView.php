<?php

namespace view;

require_once("src/model/Quiz.php");


class CreateView{

	private $model;					// Instans av CreateModel.

	private $errorMessage;

	// Statiska medlemsvariabler för att motverka strängberoenden.
	private static $title = 'title';
	private static $creator = 'creator';
	private static $submitTitle = 'submitTitle';
	private static $submitCreator = 'submitCreator';
	private static $back = 'back';

	const regEx = '/[^a-z0-9\-_\.]/i';		// Reguljärt uttryck för att ta bort "elaka" tecken.



	public function __construct(\model\QuizModel $model){
		$this->model = $model;
	}


/**
  * Submit-funktioner.
  */
	public static function back(){
		return isset($_POST[self::$back]);
	}

	public function submitTitle(){
		return isset($_POST[self::$submitTitle]);
	}

	public function submitCreator(){
		return isset($_POST[self::$submitCreator]);
	}


/**
  * Returnerar en titel.
  * Tar även bort "elaka" tecken.
  *
  * @return string Returns String title.
  */
	public function getTitle(){
		if($this->submitTitle()){

			$title = trim($_POST[self::$title]);

			if(preg_match(self::regEx, $title)){
				$title = preg_replace(self::regEx, "", $title);
			}
			if (empty($title)) {
				$this->errorMessage = "<p id='error_message'>Ditt quiz måste heta något! ;)</p>";
				return null;
			}
			return $title;
		}
	}


/**
  * Instansierar och retunerar ett nytt Quiz-objekt.
  *
  * @return object Returns Object Question.
  */
	public function getQuizToCreate(){
		if($this->submitCreator()){

			$creator = trim($_POST[self::$creator]);
			
			if (empty($creator)) {
				$this->errorMessage = "<p id='error_message'>Du måste ange en mailadress! :)</p>";
				return null;
			}

			try {
				return new \model\Quiz(NULL, $this->model->getTitleSession(), $creator);
			} catch (\Exception $e) {
				$this->errorMessage = "<p id='error_message'>Mailadressen är ogiltig! :O</p>";
			}
		}
	}


/**
  * Visar titelskaparen där man skriver in titeln och om det finns en titel lagrad visas den.
  *
  * @return string Returns String HTML.
  */
	public function showCreateTitle(){

		$errorMessage = $this->errorMessage;

		$title = "";
		
		if ($this->model->titleSessionIsset()) {
			$title = $this->model->getTitleSession();
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


/**
  * Visar quizskaparen där man skriver in sin mailadress.
  *
  * @return string Returns String HTML.
  */
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
					<input id='title_input' type='email' maxlength='255' name=' " . self::$creator . "'>
					</div>

					$errorMessage

		    		<div id='submitbuttons'>
					<input class='hiddenButton' type='submit' value='Fortsätt →' name='" . self::$submitCreator . "'>
					<input class='backButton' type='submit' value='← Tillbaka' name='" . self::$back . "'>
					<input class='continueButton' type='submit' value='Fortsätt →' name='" . self::$submitCreator . "'>
					</div>
					</form>
					</div>
				";

		return $ret;
	}
}