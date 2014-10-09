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
	private static $restart = 'restart';
	private static $delete_question = 'delete_question';
	private static $update_question = 'update_question';



	public function __construct($quizId, \model\QuizRepository $quizRepository){
		$this->quizId = $quizId;
		$this->quizRepository = $quizRepository;
	}

	public function finished(){
		return isset($_POST[self::$question_addQuestion]);
	}

	public function restart(){
		return isset($_POST[self::$restart]);
	}

	public function submitQuestion(){
		return isset($_POST[self::$question_addQuestion]);
	}

	public function getQuestionObj(){
		if(empty(trim(($_POST[self::$question])))){
			throw new \Exception("Hörrö, du har glömt att skriva en fråga ju! ;)");
		}
		return new \model\Question($this->quizId, $_POST[self::$question], $_POST[self::$answer]);
	}


	public function updateQuestion(){
		return isset($_POST[self::$update_question]);
	}

	public function getUpdatedQuestion(){
		if(empty($_POST[self::$question])){
			throw new \Exception("Du kan inte lämna frågan tom! :O");
		}
		return new \model\Question($this->quizId, $_POST[self::$question], $_POST[self::$answer], $_POST[self::$questionId]);		
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


	public function show(\model\Questions $questions){


		$ret = "
					<h4>" . $this->getTitle() . "</h4>";

		$ret .= "
				<div id='new_question_div'>
					<form method='post'>
						<label for='question_input' id='question_label'>Ny fråga?</label><br>
				        <textarea id='question_input' rows='8' cols='50' name='" . self::$question . "'></textarea><br>
						<label for='true'>Sant</label>
						<Input id='true' type='radio' Name='" . self::$answer . "' value='true' checked>		        		
						<label for='false'>Falskt</label>
						<Input id='false' type='radio' Name='" . self::$answer . "' value='false'><br>
	    				<input id='restartbutton' type='submit' value='↺ Börja om' name='" . self::$restart . "'>
	    				<input class='question_addQuestion' type='submit' value='+ Lägg till fråga' name='" . self::$question_addQuestion . "'>
	    				<input id='finishbutton' type='submit' value='Fortsätt →' name='" . self::$restart . "'>
					</form>
				</div>
				";
	/*	$ret .= "
			<a id='restartbutton' href='?".NavigationView::$action.'='.NavigationView::$actionAddTitle."'><- Börja om</a>
			<a id='finishbutton' href='?".NavigationView::$action.'='.NavigationView::$actionAddTitle."'>Färdig -></a>
		";*/
		foreach ($questions->getQuestions() as $question) {
			$this->i++;

			$ret .= "
					<div class='old_question_div'>
					<h2>" . $this->i . "</h2>
						<form method='post'>
							<input type='hidden' name='" . self::$questionId . "' value='" . $question->getQuestionId() . "'><br>
							<label for='question_input" . $this->i . "'>Fråga " . $this->i . "</label><br>
					        <textarea id='question_input" . $this->i . "' rows='4' cols='50' name='" . self::$question . "'>" . $question->getQuestion() . "</textarea><br>
			        ";
							if ($question->getAnswer() == "true") {
								$ret .= "
											<label for='true" . $this->i . "'>Sant</label>
											<Input id='true" . $this->i . "' type='radio' Name='" . self::$answer . "' value='true' checked>		        		
											<label for='false" . $this->i . "'>Falskt</label>
											<Input id='false" . $this->i . "' type='radio' Name='" . self::$answer . "' value='false'><br>
										";   							
							}
							else{
								$ret .= "
											<label for='true" . $this->i . "'>Sant</label>
											<Input id='true" . $this->i . "' type='radio' Name='" . self::$answer . "' value='true'>		        		
											<label for='false" . $this->i . "'>Falskt</label>
											<Input id='false" . $this->i . "' type='radio' Name='" . self::$answer . "' value='false' checked><br>
										";   
							}	
			$ret .= "     		
		    				<input class='update_question' type='submit' value='Uppdatera' name='" . self::$update_question . "'>
		    				<input class='delete_question' type='submit' value='Ta bort' name='" . self::$delete_question . "'>
						</form>
					</div>
					";
		}

		return $ret;
	}
}