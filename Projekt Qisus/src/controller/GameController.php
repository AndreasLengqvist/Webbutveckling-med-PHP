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
		$this->gameView = new \view\GameView($this->quizRepository);
	}


	public function setupGame(){
	
	// Hanterar indata.
		try {

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

			// Fuskförebyggande - om spelaren försöker ladda samma spel från en annan webbläsare/dator.
			if (!$this->playSession->checkPlayerAgent($this->useragent->getUserAgent())) {
				$this->playSession->unSetPlaySessions();
				\view\NavigationView::RedirectToGameView();
			}

			$gameId = $this->playSession->getGameSession();
			$playerId = $this->playSession->getPlayerSession();

		} catch (\Exception $e) {
			echo $e;
			die();
		}

	//Generar utdata.
		return $this->gameView->showQuestions($this->quizRepository->getQuestionsById($gameId), $gameId, $playerId);
	}
}