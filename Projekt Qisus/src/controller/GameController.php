<?php

namespace controller;

require_once("src/model/QuizRepository.php");
require_once("src/model/QuestionRepository.php");
require_once("src/model/AdressRepository.php");
require_once("src/model/QuizModel.php");
require_once('src/view/GameView.php');


/**
* Kontroller för att ladda och spela ett quiz.
*/
class GameController{

	private $playModel;				// Instans av PlayModel();
	private $quizRepository;		// Instans av QuizRepository();
	private $questionRepository;	// Instans av QuestionRepository();
	private $adressRepository;		// Instans av AdressRepository();	
	private $gameView;				// Instans av GameView();



/**
  * Instansiserar alla nödvändiga modeller och vyer.
  */
	public function __construct(){
		$this->playModel = new \model\QuizModel();
		$this->quizRepository = new \model\QuizRepository();
		$this->questionRepository = new \model\QuestionRepository();
		$this->adressRepository = new \model\AdressRepository();

		$this->gameView = new \view\GameView($this->playModel);
	}


/**
  * REDIRECT-SETUP-funktion.
  *
  * @return String HTML
  */
	public function setupGame(){

		// Redirects för olika URL-tillstånd.
			if ($this->playModel->playSessionsIsset()) {
				\view\NavigationView::RedirectToGameView();
			}


		// SETUP.
			$game = $this->gameView->getSetupData();
			if ($game and $game->isValid()) {

				$quiz = $game->getQuiz();
				$quizId = $game->getQuizId();
				$player = $game->getPlayer();
				$playerId = $game->getPlayerId();

				$this->playModel->setPlaySessions($quiz, $quizId, $player, $playerId);
				\view\NavigationView::RedirectToGameView();
			}


		// UTDATA.
			return $this->gameView->showSetup();
	}


/**
  * REDIRECT-READ-PLAY-SEND-funktion.
  *
  * @return String HTML
  */
	public function playGame(){


		// Redirects för olika URL-tillstånd.
			if (!$this->playModel->playSessionsIsset()) {
				\view\NavigationView::RedirectToSetupView();
			}


		// READ.
			$quiz = $this->playModel->getQuizSession();
			$quizId = $this->playModel->getQuizIdSession();
			$questionsObj = $this->questionRepository->getQuestionsById($quizId);
			$questions = $questionsObj->getQuestions();


		// PLAY.
			$this->gameView->getAnswers($questions);


		// SEND.
			if($this->playModel->answerSessionIsset()){

				$answers = $this->playModel->getAnswersSession();

				if (!in_array(null, $answers)){

					try {

						$player = $this->playModel->getPlayerSession();

						$to = $this->quizRepository->getCreatorById($quizId);
						$title = $this->gameView->renderTitle($player, $quiz);
						$message = $this->gameView->renderMessage($quiz, $player, $questions, $answers);
						$header = $this->gameView->renderHeader();

						mail($to, $title, $message, $header);

					} catch (\Exception $e) {

						error_log($e->getMessage() . "\n", 3, \Config::ERROR_LOG);

						if (\Config::DEBUG) {
							echo $e;
						} else{
							\view\NavigationView::RedirectToErrorPage();
							die();
						}
					}

					$this->playModel->checkQuizStatus();					
					return $this->gameView->showSent($to);
				}
			}


		// UTDATA.
			return $this->gameView->showQuestions($quiz, $questions);
	}
}