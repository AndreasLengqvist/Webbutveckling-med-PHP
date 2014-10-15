<?php

namespace view;

require_once("src/model/Game.php");
require_once("NavigationView.php");
require_once("src/model/QuizRepository.php");


class GameView{

	private $q;
	private $a;
	private $quizRepository;
	private $errorMessage;

	private static $question = 'question';
	private static $questionId = 'questionId';
	private static $answer = 'answer';
	private static $play = 'play';
	private static $send = 'send';



	public function __construct(\model\PlaySession $session, \model\QuizRepository $quizRepository){
		$this->quizRepository = $quizRepository;
		$this->session = $session;
	}


	public function play(){
		return isset($_POST[self::$play]);
	}


	public function send(){
		return isset($_POST[self::$send]);
	}


	public function getSetupData(){
		if($this->play()){
			try {
				$gameId = \view\NavigationView::getUrlGame();
				$playerId = \view\NavigationView::getUrlPlayer();
				return new \model\Game($gameId, $playerId);
			} catch (\Exception $e) {
				$this->errorMessage = "<p id='error_message'>Ditt spel gick inte att ladda. Var god tryck på direktlänken du fick i mailet.</p>";
			}
			return null;
		}
	}


	public function getAnswers(\model\Questions $questions){
		if ($this->send()) {

			foreach ($questions->getQuestions() as $question) {
				$answer = $question->getQuestionId();

					if (empty($_POST[$answer])) {
						$answers[$answer] = null;
						$this->session->setAnswerSession($answers);
						$this->errorMessage = "<p id='error_message'>Du måste svara på alla frågorna!</p>";
					}
					else{
						$answers[$answer] = $_POST[$answer];
						$this->session->setAnswerSession($answers);
					}
				}
			}
	}


	public function renderTitle($player, $title){
		return "Resultat på " . $title . " - ". $player;
	}


	public function renderHeader($player){
		$headers = "From: " . strip_tags($player) . "\r\n";
		$headers .= "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	   	return $headers;
	}


	public function renderMessage($gameId, $player, $title, \model\Questions $questions, $answers){

		$ret  ="		<html><body>";
		$ret .="		<h2>" . $title . "</h2>";
		$ret .="		<h3>Resultat från " . $player ."</h3>";

		foreach ($questions->getQuestions() as $question) {

				$this->q++;
				$questionId =$question->getQuestionId();

				$ret .= "<h4>Fråga " . $this->q . "</h4>";
				$ret .= "<p>" . $question->getQuestion() . "</p>";
				$ret .= "<p> Rätt svar: " . $question->getAnswer() . "</p>";

			foreach ($answers as $qId => $answer) {

				if ($qId === $questionId) {
					$ret .= "<p> Svarade: " . $answer . "</p>";
				}
			}
		}

	    $ret .="		</body></html>";
	   	return $ret;
	}


	public function showSetup(){

		$errorMessage = $this->errorMessage;

		$ret = "
					<h1 id='tiny_header'>qisus.</h1>
					<h1 id='big_header'>qisus.</h1>
					<div id='center_wrap'>
						<h2 id='home_h2'>Är du redo?</h2>
						<h3 id='arrow'>↓</h3>
						<form method='post'>
							<input id='startButton' type='submit' value='Spela' name='" . self::$play . "'>
							$errorMessage
						</form>	
						<div id='info_div'>					
							<p class='info'>Quiset består av ett antal påstående som antingen är sanna eller falska.</p>
							<p class='info'>Din uppgift är att lista ut vad som egentligen är sant eller falskt.</p>
							<p class='info'>Lycka till!</p>
						</div>
					</div>
				";
		return $ret;
	}

	public function showQuestions(\model\Questions $questions){

		$gameId = $this->session->getGameSession();
		$playerId = $this->session->getPlayerSession();
		$errorMessage = $this->errorMessage;


		$ret = "	
					<h1 id='tiny_header'>qisus.</h1>
					<h2 id='title'>
						" . $this->quizRepository->getTitleById($gameId) . "
					</h2>

					$errorMessage

					<form method='post'>
			   ";

			foreach ($questions->getQuestions() as $question) {

				$this->q++;
				$questionId =$question->getQuestionId();

				$ret .= "
						<div class='saved_div'>
						<h3 class='question_number'>" . $this->q . "</h3>
							<form method='post'>
						        <p id='question_text' class='question" . $this->q . "'>" . $question->getQuestion() . "</p>

				";

				if ($this->session->answerSessionIsset()) {

					foreach ($this->session->getAnswersSession() as $qId => $answer) {
						
						if ($qId === $questionId) {
						
							if ($answer === "true") {
								$ret .= "
								            <input type='radio' id='true" . $this->q . "' name='" . $questionId . "' value='true' checked>
										    <label class='old' for='true" . $this->q . "'>Sant</label>
										    <input type='radio' id='false" . $this->q . "' name='" . $questionId . "'value='false'>
										    <label class='old' for='false" . $this->q . "'>Falskt</label>
										";
							}
							if ($answer === "false") {
								$ret .= "
								            <input type='radio' id='true" . $this->q . "' name='" . $questionId . "' value='true'>
										    <label class='old' for='true" . $this->q . "'>Sant</label>
										    <input type='radio' id='false" . $this->q . "' name='" . $questionId . "'value='false' checked>
										    <label class='old' for='false" . $this->q . "'>Falskt</label>
										";
							}
							if($answer === null)  {
								$ret .= "
								            <input type='radio' id='true" . $this->q . "' name='" . $questionId . "' value='true'>
										    <label class='old' for='true" . $this->q . "'>Sant</label>
										    <input type='radio' id='false" . $this->q . "' name='" . $questionId . "'value='false'>
										    <label class='old' for='false" . $this->q . "'>Falskt</label>
										";
							}
						}
					}
				}
				else{
					$ret .= "
				            <input type='radio' id='true" . $this->q . "' name='" . $questionId . "' value='true'>
						    <label class='old' for='true" . $this->q . "'>Sant</label>
						    <input type='radio' id='false" . $this->q . "' name='" . $questionId . "'value='false'>
						    <label class='old' for='false" . $this->q . "'>Falskt</label>
						";

				}
			$ret .= "
						</div>
					";
			}
			$ret .= "	
							$errorMessage
							<input class='sendButton' type='submit' value='Skicka in' name='" . self::$send . "'>
						</form>
						<div id='info_div'>
							<p class='info'>När du är nöjd med dina svar så klickar du på Skicka in!</p>
							<p class='info'>Dina svar kommer då skickas till skaparen av quizet och det är också denne som presenterar resultatet.</p>
						</div>
					";
		return $ret;
	}


	public function showSent($owner){

		$ret = "
					<h1 id='tiny_header'>qisus.</h1>
					<h1 id='big_header'>qisus.</h1>
					<div id='center_wrap'>
						<h2 id='home_h2'>Dina svar skickades! :D</h2>
						<p class='info'>Dina svar kommer nu skickas till " . $owner . ", det är också denne som presenterar ditt eventuella resultat.</p>
						<p class='info'>Tack för att du spelade qisus.</p>
					</div>
				";

		return $ret;
	}
}