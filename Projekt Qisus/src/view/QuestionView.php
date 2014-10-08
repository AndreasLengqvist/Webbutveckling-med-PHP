<?php

namespace view;

require_once("src/model/Question.php");
require_once("NavigationView.php");
require_once("src/model/QuizRepository.php");


class QuestionView{

	private $quizId;
	private $quizRepository;
	private static $question = 'question';
	private static $answer = 'answer';
	private static $newQuestionSubmit = 'newQuestionSubmit';
	private static $finishedSubmit = 'finishedSubmit';



	public function __construct($quizId, \model\QuizRepository $quizRepository){
		$this->quizId = $quizId;
		$this->quizRepository = $quizRepository;
	}


	public function submitQuestion(){
		return isset($_POST[self::$newQuestionSubmit]);
	}


	public function getTitle(){
		return $this->quizRepository->getTitleById($this->quizId);
	}


	public function getQuestionObj(){
		if(empty($_POST[self::$question])){
			throw new \Exception("Hörrö, du har glömt att skriva en fråga ju! ;)");
		}
		return new \model\Question($this->quizId, $_POST[self::$question], $_POST[self::$answer]);
	}


// TODO - bryta ut menyn.
	public function show(\model\Questions $questions){


		$ret = "
					<h3>" . $this->getTitle() . "</h3>";

		$ret .= "
					<form method='post'>
						<label for='question_input' id='question_label'>Fråga</label><br>
				        <textarea id='question_input' rows='4' cols='50' name='" . self::$question . "'></textarea><br>
						<label for='true'>Sant</label>
						<Input id='true' type='radio' Name='" . self::$answer . "' value='true' checked>		        		
						<label for='false'>Falskt</label>
						<Input id='false' type='radio' Name='" . self::$answer . "' value='false'><br>
	    				<input id='question_newQuestion' type='submit' value='+ Ny fråga' name='" . self::$newQuestionSubmit . "'><br>
	    				<input id='question_finished' type='submit' value='Klar!' name='" . self::$finishedSubmit . "'>

					</form>
				";

		foreach ($questions->getQuestions() as $question) {
			$ret .= "
						<form method='post'>
							<label for='question_input' id='question_label'>Fråga</label><br>
					        <textarea id='question_input' rows='4' cols='50' name='" . self::$question . "'>" . $question->getQuestion() . "</textarea><br>
						</form>
					";
		}

		return $ret;
	}
}