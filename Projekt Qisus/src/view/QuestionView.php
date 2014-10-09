<?php

namespace view;

require_once("src/model/Question.php");
require_once("NavigationView.php");
require_once("src/model/QuizRepository.php");


class QuestionView{

	private $quizId;
	private $i;
	private $quizRepository;
	private static $question = 'question';
	private static $questionId = 'questionId';
	private static $answer = 'answer';
	private static $question_addQuestion = 'question_addQuestion';
	private static $finishedSubmit = 'finishedSubmit';
	private static $delete_question = 'delete_question';



	public function __construct($quizId, \model\QuizRepository $quizRepository){
		$this->quizId = $quizId;
		$this->quizRepository = $quizRepository;
	}


	public function submitQuestion(){
		return isset($_POST[self::$question_addQuestion]);
	}

	public function getQuestionObj(){
		if(empty($_POST[self::$question])){
			throw new \Exception("Hörrö, du har glömt att skriva en fråga ju! ;)");
		}
		return new \model\Question($this->quizId, $_POST[self::$question], $_POST[self::$answer]);
	}


	public function deleteQuestion(){
		return isset($_POST[self::$delete_question]);
	}

	public function getDeleteQuestion(){
		return new \model\Question($this->quizId, $_POST[self::$question], $_POST[self::$answer], $_POST[self::$questionId]);		
	}


	public function getTitle(){
		return $this->quizRepository->getTitleById($this->quizId);
	}




// TODO - bryta ut menyn.
	public function show(\model\Questions $questions){


		$ret = "
					<h4>" . $this->getTitle() . "</h4>";

		$ret .= "
				<div id='new_question_div'>
					<form method='post'>
						<label for='question_input' id='question_label'>Ny fråga?</label><br>
				        <textarea id='question_input' rows='4' cols='50' name='" . self::$question . "'></textarea><br>
						<label for='true'>Sant</label>
						<Input id='true' type='radio' Name='" . self::$answer . "' value='true' checked>		        		
						<label for='false'>Falskt</label>
						<Input id='false' type='radio' Name='" . self::$answer . "' value='false'><br>
	    				<input class='question_addQuestion' type='submit' value='+ Lägg till fråga' name='" . self::$question_addQuestion . "'><br>
					</form>
				</div>
				";

		foreach ($questions->getQuestions() as $question) {
			$this->i++;

			$ret .= "
					<div class='old_question_div'>
						<form method='post'>
							<input type='hidden' name='" . self::$questionId . "' value='" . $question->getQuestionId() . "'><br>
							<label for='question_input" . $this->i . "'>Fråga " . $this->i . "</label><br>
					        <textarea id='question_input" . $this->i . "' rows='4' cols='50' name='" . self::$question . "'>" . $question->getQuestion() . "</textarea><br>
							<Input id='true' type='radio' Name='" . self::$answer . "' value='true' checked>		        		
							<Input id='false' type='radio' Name='" . self::$answer . "' value='false'><br>	        		
		    				<input class='delete_question' type='submit' value='Ta bort fråga' name='" . self::$delete_question . "'><br>
						</form>
					</div>
					";
		}

		return $ret;
	}
}