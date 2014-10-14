<?php

namespace view;

require_once("src/model/Question.php");
require_once("NavigationView.php");
require_once("src/model/QuizRepository.php");


class QuestionView{

	private $quizId;
	private $i;
	private $quizRepository;
	private $errorMessage;
	private $errorOldMessage;

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
		return isset($_POST[self::$finishedSubmit]);
	}

	public function restart(){
		return isset($_POST[self::$restart]);
	}

	public function submitQuestion(){
		return isset($_POST[self::$question_addQuestion]);
	}

	public function updateQuestion(){
		return isset($_POST[self::$update_question]);
	}

	public function deleteQuestion(){
		return isset($_POST[self::$delete_question]);
	}


	public function getQuestionData(){
		if($this->submitQuestion()){
			$question = trim($_POST[self::$question]);
			if (empty($question)) {
				$this->errorMessage = "<p id='error_message'>Du har glömt att skriva en fråga! ;)</p>";
				return null;
			}
			return new \model\Question($this->quizId, $_POST[self::$question], $_POST[self::$answer], NULL);
		}
	}


	public function getUpdatedData(){
		if($this->updateQuestion()){
			$updatedquestion = trim($_POST[self::$question]);
			if (empty($updatedquestion)) {
				//$this->errorOldMessage = "<p id='error_old_question'>Du kan inte lämna frågan tom! :O</p>";
				return null;
			}
			return new \model\Question($this->quizId, $_POST[self::$question], $_POST[self::$answer], $_POST[self::$questionId]);		
		}
	}


	public function getQuestionToDelete(){
		return new \model\Question($this->quizId, $_POST[self::$question], $_POST[self::$answer], $_POST[self::$questionId]);		
	}


	public function getQuizToDelete(){
		return new \model\Quiz($this->quizId, $this->getTitle());		
	}


	public function getTitle(){
		return $this->quizRepository->getTitleById($this->quizId);
	}


	public function show(\model\Questions $questions){

		$errorMessage = $this->errorMessage;
		$errorOldMessage = $this->errorOldMessage;

		$ret = "
					<h1 id='tiny_header'>qisus.</h1>
					<h2 id='title'>" . $this->getTitle() . "</h2>";

			$ret .= "
						<div id='new_question_div'>
							<form method='post'>
								<div>
									<label for='question_input' id='question_label'>Ny fråga?</label>
						        </div>
						        <div>
						        	<textarea id='question_input' rows='8' name='" . self::$question . "'></textarea>
					           </div>
					            <div>
					            	<input type='radio' id='true' name='" . self::$answer . "' value='true' checked>
								    <label for='true'>Sant</label>

								    <input type='radio' id='false' name='" . self::$answer . "'value='false'>
								    <label for='false'>Falskt</label>
								</div>
								
								$errorMessage

								<div>
			    					<input class='addButton' type='submit' value='+ Lägg till fråga' name='" . self::$question_addQuestion . "'>  				
   								</div>
									<input class='backButton' type='submit' value='↺ Börja om' name='" . self::$restart . "'>
					";
							
   				if ($questions->getQuestions()) {
				    $ret .= "
			    					<input class='continueButton' type='submit' value='Fortsätt →' name='" . self::$finishedSubmit . "'>
			    				</div>	
							";
			$ret .= "
							</form>
						</div>
					";
				}
		
		if(!$questions->getQuestions()){
			$ret .= "
						<p>Inga frågor tillagda.</p>
					";
		}

		foreach ($questions->getQuestions() as $question) {

			$this->i++;

			$ret .= "
					<div class='saved_div'>
					<h3 class='question_number'>" . $this->i . "</h3>
						<form method='post'>
							<input type='hidden' name='" . self::$questionId . "' value='" . $question->getQuestionId() . "'>
							<label for='question_input" . $this->i . "'>Fråga " . $this->i . "</label><br>
					        <textarea id='question_input" . $this->i . "' rows='8' cols='50' name='" . self::$question . "'>" . $question->getQuestion() . "</textarea><br>
			        ";
							if ($question->getAnswer() == "true") {
								$ret .= "
								            <input type='radio' id='true" . $this->i . "' name='" . self::$answer . "' value='true' checked>
										    <label class='old' for='true" . $this->i . "'>Sant</label>
										    <input type='radio' id='false" . $this->i . "' name='" . self::$answer . "'value='false'>
										    <label class='old' for='false" . $this->i . "'>Falskt</label>
										";   							
							}
							else{
								$ret .= "
								            <input type='radio' id='true" . $this->i . "' name='" . self::$answer . "' value='true'>
										    <label class='old' for='true" . $this->i . "'>Sant</label>
										    <input type='radio' id='false" . $this->i . "' name='" . self::$answer . "'value='false' checked>
										    <label class='old' for='false" . $this->i . "'>Falskt</label>
										";   
							}	
			$ret .= "     	
							<div>
		    					<input class='updateButton' type='submit' value='Uppdatera' name='" . self::$update_question . "'>
		    					<input class='deleteButton' type='submit' value='Ta bort' name='" . self::$delete_question . "'>
							</div>
						</form>
					</div>
					";
		}

		return $ret;
	}
}