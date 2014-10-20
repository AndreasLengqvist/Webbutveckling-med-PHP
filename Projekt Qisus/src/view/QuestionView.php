<?php

namespace view;

require_once("src/model/Question.php");


class QuestionView{

	private $model;					// Instans av CreateModel.
	private $questionRepository;	// Instans av QuestionRepository.

	private $quizId;
	private $i;
	private $errorMessage;

	// Statiska medlemsvariabler för att motverka strängberoenden.
	private static $question = 'question';
	private static $questionId = 'questionId';
	private static $answer = 'answer';
	private static $addQuestion = 'addQuestion';
	private static $finishedSubmit = 'finishedSubmit';
	private static $restart = 'restart';
	private static $deleteQuestion = 'deleteQuestion';
	private static $updateQuestion = 'updateQuestion';



	public function __construct(\model\QuizModel $model, \model\QuestionRepository $questionRepository){
		$this->questionRepository = $questionRepository;
		$this->model = $model;
		$this->quizId = $this->model->getCreateSession();
	}


/**
  * Submit-funktioner.
  */
	public function finished(){
		return isset($_POST[self::$finishedSubmit]);
	}

	public function restart(){
		return isset($_POST[self::$restart]);
	}

	public function addQuestion(){
		return isset($_POST[self::$addQuestion]);
	}

	public function updateQuestion(){
		return isset($_POST[self::$updateQuestion]);
	}

	public function deleteQuestion(){
		return isset($_POST[self::$deleteQuestion]);
	}

/**
  * Instansierar och retunerar ett nytt Question-objekt.
  *
  * @return object Returns Object Question.
  */
	public function getQuestionToCreate(){
		if($this->addQuestion()){
			$question = trim($_POST[self::$question]);
			if (empty($question)) {
				$this->errorMessage = "<p id='error_message'>Du har glömt att skriva en fråga! ;)</p>";
				return null;
			}
			return new \model\Question($this->quizId, $question, $_POST[self::$answer], NULL);
		}
	}

/**
  * Instansierar och retunerar ett nytt Question-objekt för uppdatering.
  *
  * @return object Returns Object Question.
  */
	public function getQuestionToUpdate(){
		if($this->updateQuestion()){
			$question = trim($_POST[self::$question]);
			if (empty($question)) {
				return null;
			}
			return new \model\Question($this->quizId, $question, $_POST[self::$answer], $_POST[self::$questionId]);
		}
	}


/**
  * Instansierar och retunerar ett Question-objekt för borttagning.
  *
  * @return object Returns Object Question.
  */
	public function getQuestionToDelete(){
		return new \model\Question($this->quizId, $_POST[self::$question], $_POST[self::$answer], $_POST[self::$questionId]);		
	}


/**
  * Visar frågeskaparen och listar alla skapade frågor med rätt svar och sånt skit.
  *
  * @return string Returns String HTML.
  */
	public function show(){

		// READ.
			$questionsObj = $this->questionRepository->getQuestionsById($this->quizId);
			$questions = $questionsObj->getQuestions();

			$errorMessage = $this->errorMessage;

				$ret = "
							<h1 id='tiny_header'>qisus.</h1>
							<h2 id='title'>" . $this->model->getTitleSession() . "</h2>
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
		    				<input class='addButton' type='submit' value='+ Lägg till fråga' name='" . self::$addQuestion . "'>  				
							</div>
							<input class='backButton' type='submit' value='↺ Börja om' name='" . self::$restart . "'>
						";
								
				if (!empty($questions)) {
			    	$ret .= "
			    				<input class='continueButton' type='submit' value='Fortsätt →' name='" . self::$finishedSubmit . "'>
			    				</div>	
							";

				$ret .= "
							</form>
							</div>
						";
					}
			
			if(empty($questions)){
				$ret .= "
							<p>Inga frågor tillagda.</p>
						";
			}

			foreach ($questions as $question) {

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
			    		<input class='updateButton' type='submit' value='Uppdatera' name='" . self::$updateQuestion . "'>
			    		<input class='deleteButton' type='submit' value='Ta bort' name='" . self::$deleteQuestion . "'>
						</div>
						</form>
						</div>
						";
			}

		return $ret;
	}
}