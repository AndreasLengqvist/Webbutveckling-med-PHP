<?php

namespace view;

require_once("src/model/Question.php");
require_once("NavigationView.php");
require_once("src/model/QuizRepository.php");


class QuestionView{

	private $session;
	private $quizRepository;
	private static $question = 'question';
	private static $answer = 'answer';
	private static $newQuestion = 'newQuestion';
	private static $finished = 'finished';



	public function __construct(\model\Session $session){
		$this->session = $session;
	}


	public function newQuestion(){
		return isset($_POST[self::$newQuestion]);
	}


	public function getTitle(){
		$this->quizRepository = new \model\QuizRepository();
		return $this->quizRepository->getTitleById($this->session->getSession());
	}


	public function getQuestionObj($quizSession){
		if(empty($_POST[self::$question])){
			throw new \Exception("Hörrö, du har glömt att skriva en fråga! ;)");
		}
		return new \model\Question($quizSession, $_POST[self::$question], $_POST[self::$answer]);
	}
	

// TODO - bryta ut menyn.
	public function show(){


		$ret = "
					<h3>" . $this->getTitle() . "</h3>
					<form method='post'>
						<label for='question_input' id='question_label'>Fråga</label><br>
				        <textarea id='question_input' rows='4' cols='50' name='" . self::$question . "'></textarea><br>
						<label for='true'>Sant</label>
						<Input id='true' type='radio' Name='" . self::$answer . "' VALUE = 'TRUE' checked>		        		
						<label for='false'>Falskt</label>
						<Input id='false' type='radio' Name='" . self::$answer . "' VALUE = 'FALSE'><br>
	    				<input id='question_newQuestion' type='submit' value='+ Ny fråga' name='" . self::$newQuestion . "'><br>
	    				<input id='question_finished' type='submit' value='Klar!' name='" . self::$finished . "'>

					</form>
				";

		return $ret;
	}
}