<?php

namespace view;

require_once("src/model/Game.php");
require_once("NavigationView.php");
require_once("src/model/QuizRepository.php");


class GameView{

	private $i;
	private $quizRepository;
	private $errorMessage;

	private static $question = 'question';
	private static $questionId = 'questionId';
	private static $answer = 'answer';
	private static $play = 'play';
	private static $send = 'send';



	public function __construct(\model\QuizRepository $quizRepository){
		$this->quizRepository = $quizRepository;
	}


	public function play(){
		return isset($_POST[self::$play]);
	}

	public function send(){
		return isset($_POST[self::$play]);
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

	public function showQuestions(\model\Questions $questions, $gameId , $playerId){
		$ret = "	
					<h1 id='tiny_header_left'>
						" . $this->quizRepository->getAdressById($playerId) . "
					</h1>
					<h1 id='tiny_header'>qisus.</h1>
					<h2 id='title'>
						" . $this->quizRepository->getTitleById($gameId) . "
					</h2>
			   ";

			foreach ($questions->getQuestions() as $question) {

				$this->i++;

				$ret .= "
						<div class='saved_div'>
						<h3 class='question_number'>" . $this->i . "</h3>
							<form method='post'>
								<input type='hidden' name='" . self::$questionId . "' value='" . $question->getQuestionId() . "'>
						        <p id='question_text' class='question" . $this->i . "'>" . $question->getQuestion() . "</p>
					            <input type='radio' id='true" . $this->i . "' name='" . self::$answer . "' value='true' checked>
							    <label class='old' for='true" . $this->i . "'>Sant</label>
							    <input type='radio' id='false" . $this->i . "' name='" . self::$answer . "'value='false'>
							    <label class='old' for='false" . $this->i . "'>Falskt</label>
							</form>
						</div>
						";
			}
			$ret .= "	
						<form method='post'>
							<input class='sendButton' type='submit' value='Skicka in' name='" . self::$send . "'>
						</form>
						<div id='info_div'>
							<p class='info'>När du är nöjd med dina svar så klickar du på Skicka in!</p>
							<p class='info'>Dina svar kommer då skickas till skaparen av quizet och det är också denne som presenterar resultatet.</p>
						</div>
					";
		return $ret;
	}
}