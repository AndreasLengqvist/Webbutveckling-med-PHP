<?php

namespace view;

require_once("src/model/Question.php");


class QuestionView{

	private $session;
	private $quizRepository;

	private $quizId;
	private $i;
	private $errorMessage;

	private static $question = 'question';
	private static $questionId = 'questionId';
	private static $answer = 'answer';
	private static $add_question = 'add_question';
	private static $finishedSubmit = 'finishedSubmit';
	private static $restart = 'restart';
	private static $delete_question = 'delete_question';
	private static $update_question = 'update_question';



	public function __construct(\model\CreateSession $session, \model\QuizRepository $quizRepository){
		$this->session = $session;
		$this->quizRepository = $quizRepository;

		$this->quizId = $this->session->getCreateSession();
	}


	public function finished(){
		return isset($_POST[self::$finishedSubmit]);
	}

	public function restart(){
		return isset($_POST[self::$restart]);
	}

	public function addQuestion(){
		return isset($_POST[self::$add_question]);
	}

	public function updateQuestion(){
		return isset($_POST[self::$update_question]);
	}

	public function deleteQuestion(){
		return isset($_POST[self::$delete_question]);
	}


	public function getAddData(){
		if($this->addQuestion()){
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
				return null;
			}
			return new \model\Question($this->quizId, $_POST[self::$question], $_POST[self::$answer], $_POST[self::$questionId]);		
		}
	}


	public function getQuestionToDelete(){
		return new \model\Question($this->quizId, $_POST[self::$question], $_POST[self::$answer], $_POST[self::$questionId]);		
	}


	public function getQuizToDelete(){
		return new \model\Quiz($this->quizId, "delete", "delete@this.com");		
	}


	public function getTitle(){
		return $this->quizRepository->getTitleById($this->quizId);
	}


	public function show(){

		$questions = $this->quizRepository->getQuestionsById($this->quizId);
		$errorMessage = $this->errorMessage;

		$ret = "
					<h1 id='tiny_header'>qisus.</h1>
					<h2 id='title'>" . $this->getTitle() . "</h2>";

			$ret .= "
						<div id='new_question_div'>
							<form method='post'>
								<div>
									<label for='question_input' id='question_label'>Skapa fråga..</label>
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
			    					<input class='addButton' type='submit' value='+ Lägg till fråga' name='" . self::$add_question . "'>  				
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