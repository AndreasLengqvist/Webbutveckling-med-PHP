<?php

namespace controller;

require_once("common/UserAgent.php");
require_once('src/view/GameView.php');
require_once("src/model/QuizRepository.php");
require_once("src/model/PlaySession.php");


class GameController{

	private $game;
	private $player;



	public function __construct(\model\PlaySession $playSession){
		$this->playSession = $playSession;
		$this->useragent = new \UserAgent();
		$this->quizRepository = new \model\QuizRepository();
		$this->gameView = new \view\GameView($this->playSession, $this->quizRepository);
	}


	public function setupGame(){
	
	// Hanterar indata.
		try {

			if ($this->playSession->playSessionsIsset()) {
				return $this->playGame();
			}

			$game = $this->gameView->getSetupData();

			// När spelaren trycker på spela.
				if ($game and $game->isValid()) {
					$this->playSession->setPlaySessions($game->getGameId(), $game->getPlayerId(), $this->useragent->getUserAgent());
					\view\NavigationView::RedirectToGameView();
				}

		} catch (\Exception $e) {
			echo $e;
			die();
		}

	// Generar utdata.
		return $this->gameView->showSetup();
	}


	public function playGame(){

	// Hanterar indata.
		try {
			
			if (!$this->playSession->playSessionsIsset()) {
				return $this->setupGame();
			}

			// Fuskförebyggande - om spelaren försöker ladda samma spel från en annan webbläsare/dator.
			if (!$this->playSession->checkPlayerAgent($this->useragent->getUserAgent())) {
				$this->playSession->unSetPlaySessions();
				\view\NavigationView::RedirectToGameView();
			}

			$gameId = $this->playSession->getGameSession();
			$playerId = $this->playSession->getPlayerSession();
			$questions = $this->quizRepository->getQuestionsById($gameId);

			$this->gameView->getAnswers($questions);

			if($this->playSession->answerSessionIsset()){
				$answers = $this->playSession->getAnswersSession();

				if (!in_array(null, $answers)){
					$titleToRender = $this->quizRepository->getTitleById($gameId);
					$player = $this->quizRepository->getAdressById($playerId);
					$to = $this->quizRepository->getCreatorById($gameId);
					$title = $this->gameView->renderTitle($player, $titleToRender);
					$message = $this->gameView->renderMessage($gameId, $player, $titleToRender, $questions, $answers);
					$header = $this->gameView->renderHeader($player);
					mail($to, $title, $message, $header);

					$this->playSession->unSetPlaySessions();
					
					return $this->gameView->showSent($to);
				}
			}




		} catch (\Exception $e) {
			echo $e;
			die();
		}

	//Generar utdata.
		return $this->gameView->showQuestions($questions);
	}
}